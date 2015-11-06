<?php


namespace common\components;


class Migration extends \yii\db\Migration
{
    /**
     * @param bool|false $notNull
     * @param null $length
     * @param bool|true $unsigned
     * @return string
     */
    public function int($notNull = false, $length = null, $unsigned = true)
    {
        return parent::integer($length === null && $unsigned ? 10 : $length) . ($unsigned ? ' unsigned' : '')
        . ($notNull ? ' NOT NULL' : '');
    }

    /**
     * @param bool|true $autoIncrement
     * @param null $length
     * @param bool|true $unsigned
     * @return string
     */
    public function primary($autoIncrement = true, $length = null, $unsigned = true)
    {
        return parent::integer($length === null ? 10 : $length) . ($unsigned ? ' unsigned' : '') . ' NOT NULL'
        . ($autoIncrement ? ' AUTO_INCREMENT' : '') . ' PRIMARY KEY';
    }

    /**
     * @param array $params
     * @param bool|false $notNull
     * @return string
     */
    public function enum(array $params, $notNull = false)
    {
        return 'enum(' . (count($params) ? '"' . implode('", "', $params) . '"' : '') . ')' . ($notNull ? ' NOT NULL' : '');
    }

    /**
     * @param bool|false $notNull
     * @param null $length
     * @param bool|true $unsigned
     * @return string
     */
    public function tinyint($length = null, $notNull = false, $unsigned = true)
    {
        return 'tinyint(' . ($length === null && $unsigned ? 3 : $length) . ')' . ($unsigned ? ' unsigned' : '')
        . ($notNull ? ' NOT NULL' : '');
    }
}