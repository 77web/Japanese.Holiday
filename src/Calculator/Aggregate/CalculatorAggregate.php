<?php


namespace Japanese\Holiday\Calculator\Aggregate;

use Japanese\Holiday\Entity\Holiday;
use Japanese\Holiday\Calculator\Calculator;

abstract class CalculatorAggregate
{
    const SUBSTITUTE_HOLIDAY_CAPTION = '振替休日';

    /**
     * @var Calculator[]
     */
    protected $calculators;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param int $year
     * @return Holiday[]
     */
    public function computeDates($year)
    {
        $baseHolidays = [];
        // 1. 祝日を全て先に設定から計算（振替休日は除く）
        foreach ($this->configuration as $name => $definition) {
            if (isset($this->calculators[$definition['type']])) {
                $date = $this->calculators[$definition['type']]->computeDate($year, $definition);

                $baseHolidays[$date->format('Y-m-d')] = [
                    'holiday' => new Holiday($date, $definition['caption']),
                    'type' => $definition['type']
                ];
            }
        }

        // 2. 振替休日を追加する
        $holidays = $baseHolidays;
        foreach ($baseHolidays as $dateStr => $data) {
            $holiday = $data['holiday'];
            $type = $data['type'];
            $date = $holiday->getDate();

            // 日曜日かつ、typeが「happymonday」でない場合に振替対象とする
            if ($date->format('N') == 7 && $type !== 'happymonday') {
                $offset = 1;
                do {
                    // 振替休日候補を計算
                    $candidate = $this->calculators['substitution']->computeDate($year, [
                        'holiday_at_sunday' => $date,
                        'offset' => $offset
                    ]);
                    $candidateKey = $candidate->format('Y-m-d');
                    $offset++;
                    // 候補日が固定祝日リストまたは既に追加された振替休日に含まれていれば、さらに次の日をチェック
                } while (isset($baseHolidays[$candidateKey]));

                // 空いている日が見つかったら振替休日として登録
                $holidays[$candidateKey] = [
                    'holiday' => new Holiday($candidate, self::SUBSTITUTE_HOLIDAY_CAPTION),
                    'type' => 'substitution'
                ];
            }
        }

        // 日付のキーが昇順になるようにソートする
        ksort($holidays);

        // 最終的な結果だけHolidayオブジェクトの配列に変換
        $result = [];
        foreach ($holidays as $entry) {
            $result[$entry['holiday']->getDate()->format('Y-m-d')] = $entry['holiday'];
        }

        return $result;
    }
}
