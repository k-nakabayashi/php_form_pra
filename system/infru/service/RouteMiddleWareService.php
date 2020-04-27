<?php

class RouteMiddleWareService {

    //middleWare
    private static $m_wrapperMiddle = [
        'before' => null,
        'after' => null,
    ];
    private $m_singleMiddle = [
        'before' => null,
        'after' => null,
    ];

    public static function setWrapperMiddle(
        $i_middleBefore = null, $i_middleAfter =null , $callBacks
        )
    {
        //before
        if(isset($i_middleBefore)) {
            $type = gettype($i_middleBefore);
            if($type === "string") {
                $i_middleBefore = [$i_middleBefore];
            }
            self::$m_wrapperMiddle['before'] = $i_middleBefore;
        }

        //after
        if(isset($i_middleAfter)) {
            $type = gettype($i_middleAfter);
            if($type === "string") {
                $i_middleAfter = [$i_middleAfter];
            }
            self::$m_wrapperMiddle['after'] = $i_middleAfter;
        }

        $callBacks();
        
        //初期化
        self::$m_wrapperMiddle = null;
    }

    public function middleBefore($i_middleWare)
    {
        $this->setSingleMiddleWare($i_middleWare, 'before');
        return $this;
    }

    public function middleAfter($i_middleWare)
    {
        $this->setSingleMiddleWare($i_middleWare, 'after');
        return $this;
    }

    private function setSingleMiddleWare($i_middleWare, $i_timing) {
        if(empty($this->m_singleMiddle[$i_timing])) {

            $type = gettype($i_middleWare);
            if($type === "string") {
                $i_middleWare = [$i_middleWare];
            }
            $this->m_singleMiddle[$i_timing] = $i_middleWare;
            return;
        }

        //すでに登録済みの場合
        $type = gettype($i_middleWare);
        if($type === "string") {
            array_push($this->m_singleMiddle[$i_timing], $i_middleWare);
        } else if($type === $i_timing) {
            foreach($i_middleWare as $middleName) {
                array_push($this->m_singleMiddle[$i_timing], $middleName);
            }  
        }
    }

    public static function getMiddleWrapper()
    {
        return self::$m_wrapperMiddle;
    }

    public function getMiddleSingle()
    {
        return $this->m_singleMiddle;
    }
}