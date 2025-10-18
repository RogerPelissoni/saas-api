<?php
if (!function_exists('sql_dump')) {
  function sql_dump($query, bool $return = false)
  {
    $sql = $query->toSql();
    $bindings = $query->getBindings();

    $sqlFormatted = str_replace('%', '%%', $sql);
    $sqlFormatted = str_replace('?', "'%s'", $sqlFormatted);
    $sqlFormatted = vsprintf($sqlFormatted, array_map(function ($binding) {
      if ($binding === null)
        return 'NULL';
      if (is_bool($binding))
        return $binding ? '1' : '0';
      if (is_numeric($binding))
        return $binding;
      return addslashes($binding);
    }, $bindings));

    if ($return) {
      return $sqlFormatted;
    }

    info($sqlFormatted);
  }
}
