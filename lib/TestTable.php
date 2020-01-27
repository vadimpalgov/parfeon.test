<?php
namespace Parfeon\Test;

use Bitrix\Main;
use Bitrix\Main\ORM\Event;
use Bitrix\Main\ORM\EventResult;
use Bitrix\Main\Type\Date;


/**
 * Class TestTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> name string(255) mandatory
 * <li> address string(255) mandatory
 * <li> created_at datetime mandatory
 * <li> updated_at datetime mandatory
 * </ul>
 *
 * @package Parfeon\Test
 **/

class TestTable extends Main\Entity\DataManager
{
    /**
     * Возвращаем название таблицы
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'b_parfeon_test';
    }

    /**
     * Структура таблицы
     *
     * @return array
     */
    public static function getMap()
    {
        return array(
            'id' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'name' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateName'),
            ),
            'address' => array(
                'data_type' => 'string',
                'required' => true,
                'validation' => array(__CLASS__, 'validateAddress'),
            ),
            'created_at' => array(
                'data_type' => 'datetime',
            ),
            'updated_at' => array(
                'data_type' => 'datetime',
                'required' => true,
            ),
        );
    }

    /**
     * Валидируем название
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateName()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Валидируем адрес
     *
     * @return array
     * @throws Main\ArgumentTypeException
     */
    public static function validateAddress()
    {
        return array(
            new Main\Entity\Validator\Length(null, 255),
        );
    }

    /**
     * Перед добавлением в базу устанавливаем даты
     * @param Event $event
     * @return EventResult
     * @throws Main\ObjectException
     */
    public static function onBeforeAdd(Event $event)
    {
        $result = new EventResult;
        $data = $event->getParameter("fields");

        $mFields = [];

        if(!isset($data['created_at'])){
            $mFields['created_at'] = new Date(null, 'Y-m-d H:i:s');
        }

        if(!isset($data['updated_at'])){
            $mFields['updated_at'] = new Date(null, 'Y-m-d H:i:s');
        }

        if($mFields){
            $result->modifyFields($mFields);
        }

        return $result;
    }

    /**
     * Перед обновлением устанавливаем дату обновления
     * @param Event $event
     * @return EventResult
     * @throws Main\ObjectException
     */
    public static function onBeforeUpdate(Event $event)
    {
        $result = new EventResult;
        $data = $event->getParameter("fields");

        if (!isset($data['updated_at']))
        {

            $result->modifyFields(array('updated_at' => new Date(null, 'Y-m-d H:i:s')));
        }

        return $result;
    }
}