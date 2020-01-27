<?php

namespace Parfeon\Test;

/**
 * Class Service
 * @package Parfeon\Test
 */
class Service
{
    /**
     * Возвращаем список методов для REST
     * @return array
     */
    public static function getRestMethods(): array
    {
        $scopes['parfeon:test'] = [
            'parfeon.test.list' => array(
                'callback' => array(__CLASS__, 'list'),
            ),
            'parfeon.test.view' => array(
                'callback' => array(__CLASS__, 'view'),
            ),
            'parfeon.test.add' => array(
                'callback' => array(__CLASS__, 'add')
            ),
            'parfeon.test.update' => array(
                'callback' => array(__CLASS__, 'update')
            ),
            'parfeon.test.remove' => array(
                'callback' => array(__CLASS__, 'remove')
            ),
        ];

        return $scopes;
    }

    /**
     * Просмотр списка значений из таблицы
     * @param $query
     * @param $n
     * @param \CRestServer $server
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function list($query, $n, \CRestServer $server)
    {
        $arRes = TestTable::getList();

        $result = [];
        while ($raw = $arRes->fetchRaw())
        {
            $result[$raw['id']] = $raw;
        }

        return $result;
    }

    /**
     * Просмотр конкретного значения из таблицы
     * @param $query
     * @param $n
     * @param \CRestServer $server
     * @return array|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function view($query, $n, \CRestServer $server)
    {

        $result = TestTable::getRowById($query['id']);

        if(is_null($result))
        {
            return ['result'=> 'error', 'error' => 'Объект не найден'];
        }

        return $result;
    }

    /**
     * Добавление записи в таблицы
     * @param $query
     * @param $n
     * @param \CRestServer $server
     * @return array
     * @throws \Exception
     */
    public static function add($query, $n, \CRestServer $server)
    {
        $result = TestTable::add($query);

        if ($result->isSuccess())
        {
            return ['id' => $result->getId()];
        }

        return ['result'=> 'error', 'error' => $result->getErrorMessages()];
    }

    /**
     * Изменение записи из таблицы
     * @param $query
     * @param $n
     * @param \CRestServer $server
     * @return array
     * @throws \Exception
     */
    public static function update($query, $n, \CRestServer $server)
    {
        $id = $query['id'];
        unset($query['id']);

        $result = TestTable::update($id,$query);

        if ($result->isSuccess()) {
            return ['id' => $result->getId()];
        }

        return ['result'=> 'error', 'error' => $result->getErrorMessages()];
    }

    /**
     * Удаление записи из таблицы
     * @param $query
     * @param $n
     * @param \CRestServer $server
     * @return array
     * @throws \Exception
     */
    public static function remove($query, $n, \CRestServer $server)
    {
        $result = TestTable::delete($query['id']);

        if ($result->isSuccess()) {
            return ['result' => 'success'];
        }

        return ['result'=> 'error', 'error' => $result->getErrorMessages()];
    }
}