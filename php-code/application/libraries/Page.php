    <?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Page
    {

        public $count;

        public $url;

        // 分页url
        public $limit;

        // 分页大小
        public $page;

        // 初始化数据
        public function __construct($param)
        {
            $this->count =  $param['count'];
            $this->url = $param['url'];
            $this->limit = $param['limit'];
            $this->page  = $param['page'];
            if (empty($this->page)) {
                $this->page = 1;
            }
            if (empty($this->limit)) {
                $this->limit = 10;
            }
            $this->page += 1;
        }

        // 分页样式输出
        public function page_nums()
        {
            $allpage = ceil(intval($this -> count) / intval($this->limit)); // 总页数
            if ($allpage > 1 && $this -> page <= $allpage)  {
                if ( strstr($this -> url, '?')) {
                    $url = $this -> url.'&limit=' . $this -> limit .'&page=' . $this -> page;
                } else {
                    $url = $this -> url.'?limit=' . $this -> limit .'&page=' . $this -> page;
                }
                $p = '<a href = "'.$url.'" class="get-more-list" style="display:none;" data-href = "'.$url.'">'.
                        '<span>加载更多</span>'.
                        '</a>';
                return $p;
            }
        }
    }