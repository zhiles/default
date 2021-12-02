<?php
class anime
{
    public $total;  // 追番总数
    public $pageNo; //当前页码
    public $pageSize;   //每页显示数量
    public $totalPages; //总页码
    public $data;

    function convert($str){
        if($str != "0" && stripos($str, "第")){
            $start = stripos($str, "第");
            $end = stripos($str, "话");
            if(empty($end)){
                $end = stripos($str, "集");
            }
            return substr($str, $start + 3, $end - $start - 3);
        }
        return $str;
    }

    // 观看进度
    function progress($str1, $str2)
    {
        $str1 = empty($str1)?"0":$str1;
        $str2 = empty($str2)?"0":$str2;
        $str1 = $this->convert($str1);
        if($str1 == "0"){
            return "貌似还没有看呢~";
        }elseif (is_numeric($str1) && $str2 == "-1") {
            return "第" . $str1 . "话/连载中";
        }elseif (is_numeric($str1) && is_numeric($str2)) {
            return "第" . $str1 . "话/共" . $str2 . "话";
        } elseif ($str2 == "0") {
            return "还没开始更新呢~";
        } else {
            return $str1;
        }
    }
    // 观看进度条
    function progress_bar($str1, $str2)
    {
        $str1 = empty($str1)?"0":$str1;
        $str2 = empty($str2)?"0":$str2;
        $str1 = $this->convert($str1);
        if (is_numeric($str1) && is_numeric($str2)) {
            return ($str1 / $str2 * 100) . "%";
        } elseif ($str1 == "0" || $str2 == "0") {
            return "0%";
        } else {
            return "100%";
        }
    }

    public function __construct($uid,$cookie,$pn,$ps)
    {
        $headrs = array('http'=>array(
            'user-agent'=> "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.55 Safari/537.36 Edg/96.0.1054.34",
            'header'=>'cookie:'.$cookie.''
        ));
        $opts = stream_context_create($headrs);
        $url = "https://api.bilibili.com/x/space/bangumi/follow/list?type=1&follow_status=0&pn=$pn&ps=$ps&vmid=$uid";
        $info = json_decode(file_get_contents($url,false,$opts), true);
        $list = [];
        $i = 0;
        foreach ($info['data']['list'] as $data) {
            $list[$i]['title'] = $data['title'];
            $list[$i]['areas'] = $data['areas'];
            $list[$i]['image'] = str_replace('http://', '//', $data['cover']);
            $list[$i]['url'] = str_replace('https://', '//', $data['url']);
            $list[$i]['number'] = $data['total_count'];
            $list[$i]['progress'] = $this->progress($data['progress'],$data['total_count']);
            $list[$i]['evaluate'] = $data['evaluate'];
            $list[$i]['progress_bar'] = $this->progress_bar($data['progress'],$data['total_count']);
            $i ++;
        }
        $this -> data = $list;
        $this -> total = $info['data']['total'];
        $this -> pageNo = $pn;
        $this -> pageSize = $ps;
        $this -> totalPages= ceil($this -> total / $ps);
    }
}
