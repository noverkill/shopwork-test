<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include 'SingleManned.php';

final class SingleMannedTest extends TestCase
{
    public function testMonday (): void
    {
        $rota = new Rota ([
            'shopName' => 'FunHouse', 
            'weekCommenceDate' => '04-10-2021', 
            'day' => 'Monday', 
            'shifts' => [
                new Shift ([
                    'workerName' => 'Black Widow', 
                    'startTime' => 8, 
                    'endTime' => 22
                ])
            ]
        ]);

        $smHours = (new SingleManningCalc())->run($rota);
        
        $this->assertEquals(14*60, $smHours->total);

        $workers = $smHours->workers;
        
        $this->assertCount(1, $workers);
        
        $this->assertArrayHasKey('Black Widow', $workers);
        $this->assertEquals(14*60, $workers['Black Widow']);

    }

    public function testRotaTuesday (): void
    {
        $rota = new Rota ([
            'shopName' => 'FunHouse', 
            'weekCommenceDate' => '04-10-2021', 
            'day' => 'Tuesday', 
            'shifts' => [
                new Shift ([
                    'workerName' => 'Black Widow', 
                    'startTime' => 8, 
                    'endTime' => 15
                ]),
                new Shift ([
                    'workerName' => 'Thor', 
                    'startTime' => 15, 
                    'endTime' => 22
                ])
            ]
        ]);

        $smHours = (new SingleManningCalc())->run($rota);
        
        $this->assertEquals(14*60, $smHours->total);

        $workers = $smHours->workers;
        
        $this->assertCount(2, $workers);

        $this->assertArrayHasKey('Black Widow', $workers);
        $this->assertEquals(7*60, $workers['Black Widow']);
        
        $this->assertArrayHasKey('Thor', $workers);
        $this->assertEquals(7*60, $workers['Thor']);
    }    

    public function testRotaWednesday (): void
    {        
        $rota = new Rota ([
            'shopName' => 'FunHouse', 
            'weekCommenceDate' => '04-10-2021', 
            'day' => 'Wednesday', 
            'shifts' => [
                new Shift ([
                    'workerName' => 'Wolverine', 
                    'startTime' => 8, 
                    'endTime' => 16
                ]),
                new Shift ([
                    'workerName' => 'Gamora', 
                    'startTime' => 10, 
                    'endTime' => 22
                ])
            ]
        ]);

        $smHours = (new SingleManningCalc())->run($rota);

        $this->assertEquals(8*60, $smHours->total);

        $workers = $smHours->workers;

        $this->assertCount(2, $workers);

        $this->assertArrayHasKey('Wolverine', $workers);
        $this->assertEquals(2*60, $workers['Wolverine']);
        
        $this->assertArrayHasKey('Gamora', $workers);
        $this->assertEquals(6*60, $workers['Gamora']);
    }

    /*
        One extra test:

        __Given__ Black widow, Thor, Wolverine and Gamora all working at FunHouse on Thursday

        __When__ Black Widow works in the morning shift

        __And__ Thor comes 2 hours later to help him 
        
        __And__ Thor also do the evening shift but leaves 2 hours earlier 

        __And__ Wolverine and Gamora work together for the last two hours

        __Then__ Black Widow receives 2 hours and Thor receives 4 hours of single manning supplements
    */
    public function testRotaThursday (): void
    {        
        $rota = new Rota ([
            'shopName' => 'FunHouse', 
            'weekCommenceDate' => '04-10-2021', 
            'day' => 'Thursday', 
            'shifts' => [
                new Shift ([
                    'workerName' => 'Black Widow', 
                    'startTime' => 8, 
                    'endTime' => 16
                ]),                
                new Shift ([
                    'workerName' => 'Thor', 
                    'startTime' => 10, 
                    'endTime' => 20
                ]),                
                new Shift ([
                    'workerName' => 'Wolverine', 
                    'startTime' => 20, 
                    'endTime' => 22
                ]),
                new Shift ([
                    'workerName' => 'Gamora', 
                    'startTime' => 20, 
                    'endTime' => 22
                ])
            ]
        ]);

        $smHours = (new SingleManningCalc())->run($rota);
        
        $this->assertEquals(6*60, $smHours->total);

        $workers = $smHours->workers;

        $this->assertCount(2, $workers);

        $this->assertArrayHasKey('Black Widow', $workers);
        $this->assertEquals(2*60, $workers['Black Widow']);

        $this->assertArrayHasKey('Thor', $workers);
        $this->assertEquals(4*60, $workers['Thor']);
    }
}