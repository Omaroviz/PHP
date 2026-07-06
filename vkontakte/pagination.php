<?php
class Pagination {
    private $pdo;
    private $limit;
    private $currentPage;
    private $totalRows;
    private $totalPages;

    public function __construct($pdo, $table, $limit = 10, $where = '') {
        $this->pdo = $pdo;
        $this->limit = (int)$limit;

        // Считаем общее количество записей (с учётом WHERE, если есть)
        $sql = "SELECT COUNT(*) FROM $table $where";
        $stmt = $this->pdo->query($sql);
        $this->totalRows = $stmt->fetchColumn();
        
        $this->totalPages = ceil($this->totalRows / $this->limit);

        $this->currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($this->currentPage < 1) $this->currentPage = 1;
        if ($this->currentPage > $this->totalPages && $this->totalPages > 0) {
            $this->currentPage = $this->totalPages;
        }
    }

    public function getSqlLimit() {
        $offset = ($this->currentPage - 1) * $this->limit;
        return "LIMIT {$this->limit} OFFSET {$offset}";
    }

    public function getNavData() {
        return [
            'current' => $this->currentPage,
            'total'   => $this->totalPages,
            'prev'    => ($this->currentPage > 1) ? $this->currentPage - 1 : null,
            'next'    => ($this->currentPage < $this->totalPages) ? $this->currentPage + 1 : null,
        ];
    }

    public function renderLinks($baseUrl = '?') {
        $nav = $this->getNavData();
        if ($nav['total'] <= 1) return '';

        $html = '<div class="pagination">';
        
        if ($nav['prev']) {
            $html .= '<a href="' . $baseUrl . 'page=' . $nav['prev'] . '">← Назад</a>';
        } else {
            $html .= '<span class="disabled">← Назад</span>';
        }

        $start = max(1, $nav['current'] - 2);
        $end = min($nav['total'], $nav['current'] + 2);
        
        if ($start > 1) {
            $html .= '<a href="' . $baseUrl . 'page=1">1</a>';
            if ($start > 2) $html .= '<span>...</span>';
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $nav['current']) {
                $html .= '<span class="current">' . $i . '</span>';
            } else {
                $html .= '<a href="' . $baseUrl . 'page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($end < $nav['total']) {
            if ($end < $nav['total'] - 1) $html .= '<span>...</span>';
            $html .= '<a href="' . $baseUrl . 'page=' . $nav['total'] . '">' . $nav['total'] . '</a>';
        }

        if ($nav['next']) {
            $html .= '<a href="' . $baseUrl . 'page=' . $nav['next'] . '">Вперед →</a>';
        } else {
            $html .= '<span class="disabled">Вперед →</span>';
        }

        $html .= '</div>';
        return $html;
    }
}
?>
