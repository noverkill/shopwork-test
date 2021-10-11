<?php

/**
 * Shift DTO class. 
 *
 * @property string $workerName Worker's name.
 * @property int $startTime Shift shart time.
 * @property int $endTime   Shift end time.
 */
class Shift
{
    use DTO;
    protected string $workerName;
    protected int $startTime;
    protected int $endTime;
}

/**
 * Rota DTO class. 
 *
 * @property string $shopName Shop's name.
 * @property string $weekCommenceDate Week's start date.
 * @property string $day Name of the day.
 * @property Shift[] $shifts Array of daily shifts.
 */
class Rota
{
    use DTO;
    protected string $shopName;
    protected string $weekCommenceDate;
    protected string $day;
    protected array $shifts;
}

/**
 * SingleManning DTO class to hold number of 
 * simgle manned minutes worked in a day in a shop.
 *
 * @property int $total Total single manned minutes.
 * @property array $workers Single manned minutes by workers.
 */
class SingleManning
{
    use DTO;
    protected int $total;
    protected array $workers;
}

/**
 * Calculate single manning hours 
 * from a daily rota.
 */
class SingleManningCalc
{
    /**
     * Method doing the calculation
     *
     * @param Rota $rota The daily rota.
     * 
     * @return SingleManning
     */
    public function run (Rota $rota) : SingleManning
    {   
        $hourly_workers = []; // Array of workers per hour
        $single_manned = [];  // Array of single manned hours with worker's name
        $hours = $this->getHours($rota);  // Get the first and last hour from shifts
        // Scan working hours fro the day
        for ($hour = $hours['first']; $hour < $hours['last']; $hour++) 
        {
            // Collect workers worked at this hour based on their shifts
            $hourly_workers[$hour] = [];
            foreach($rota->shifts as $shift) 
            {
                if($hour >= $shift->startTime && $hour < $shift->endTime) 
                {
                    $hourly_workers[$hour][] = $shift->workerName;
                }
            }
            // If there was only one worker for this hour, 
            // then save it as a single manned hour with the worker's name
            if(count($hourly_workers[$hour]) == 1) 
            {
                $single_manned[$hour] = $hourly_workers[$hour][0];  
            }
        }
        
        // Count single worked hours
        $single_manned_hours = array_count_values($single_manned);
        // Translate it to minutes
        $single_manned_minutes = array_map(function($hour){return $hour * 60;}, $single_manned_hours);
        // Calculate total minutes
        $total = array_sum($single_manned_minutes);
        
        return new SingleManning ([
            'workers' => $single_manned_minutes, 
            'total' => $total
        ]);
    }
 
    /**
     * Get first and last working hour for the day.
     */
    protected function getHours (Rota $rota)
    {
        $first = 23; $last = 0;
        foreach($rota->shifts as $shift) {
            $first = min($shift->startTime, $first);
            $last = max($shift->endTime, $last);
        }
        return [
            'first' => $first, 
            'last' => $last
        ];
    }
}

/**
 * Generic methods for DTOs
 */
trait DTO
{
    /**
     * Constructing DTOs from an assoc array
     */
    public function __construct() {
        $properties = func_get_args()[0];
        foreach ($properties as $property => $value) 
        {
            if (property_exists($this, $property)) 
            {
                $this->$property = $value;
            }
        }
    }

    /**
     * Get protected properties 
     * using magic method.
     */
    public function __get($property) 
    {
        if (property_exists($this, $property)) 
        {
            return $this->$property;
        }
    }
}