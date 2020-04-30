<?php


namespace App\Lib\TestResults;


class StrictMarkEvaluator implements MarkEvaluatorInterface
{
    /**
     * @inheritDoc
     */
    public function putMark(float $fullTestScore): int
    {
    	$fullTestScore *= 100;

    	if ($fullTestScore < 60){
    		return 2;
    	}

    	if ($fullTestScore < 75) {
    		return 3;
    	}

    	if ($fullTestScore < 95) {
    		return 4;
    	}

    	return 5;
        //return max(1, (int)round($fullTestScore * 5 - 0.1));
    }
}
