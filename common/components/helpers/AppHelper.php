<?php

namespace common\components\helpers;

use Yii;
use yii\web\BadRequestHttpException;

class AppHelper extends \yii\base\Component
{
    /**
    * Свойство для таймеров
    * @return integer
    */
    public static $UPDATE_TIMER = 300;
    /**
    * Тип - вещь
    * @return string
    */
    public static $TYPE_ITEM = 'item';
    /**
    * Тип - задание
    * @return string
    */
    public static $TYPE_QUEST = 'quest';
    /**
    * Тип - заклинание
    * @return string
    */
    public static $TYPE_SPELL = 'spell';
    /**
    * Тип - достижение
    * @return string
    */
    public static $TYPE_ACHIEVEMENT = 'achievement';
    /**
    * Индекс поля для усиления (энчата)
    * @return integer
    */
    public static $ENCHAT_FIELD = 0;
    /**
    * Индекс поля для камня усиления (сокета) 1
    * @return integer
    */
    public static $SOCKET_FIELD_1 = 6;
    /**
    * Индекс поля для камня усиления (сокета) 2
    * @return integer
    */
    public static $SOCKET_FIELD_2 = 9;
    /**
    * Индекс поля для камня усиления (сокета) 3
    * @return integer
    */
    public static $SOCKET_FIELD_3 = 12;
    /**
    * Массив доступных слотов у персонажа
    * @return array
    */
    public static $ARRAY_SLOTS = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
    /**
    * Слот головы
    * @return integer
    */
    public static $INV_HEAD = 0;
    /**
    * Слот шеи
    * @return integer
    */
    public static $INV_NECK = 1;
    /**
    * Слот плеч
    * @return integer
    */
    public static $INV_SHOULDER = 2;
    /**
    * Слот рубашка
    * @return integer
    */
    public static $INV_SHIRT = 3;
    /**
    * Слот грудь
    * @return integer
    */
    public static $INV_CHEST = 4;
    /**
    * Слот пояс
    * @return integer
    */
    public static $INV_BELT = 5;
    /**
    * Слот ноги
    * @return integer
    */
    public static $INV_LEGS = 6;
    /**
    * Слот ботинки
    * @return integer
    */
    public static $INV_BOOTS = 7;
    /**
    * Слот запястья
    * @return integer
    */
    public static $INV_WRIST = 8;
    /**
    * Слот перчатки
    * @return integer
    */
    public static $INV_GLOVES = 9;
    /**
    * Слот кольцо 1
    * @return integer
    */
    public static $INV_RING_1 = 10;
    /**
    * Слот кольцо 2
    * @return integer
    */
    public static $INV_RING_2 = 11;
    /**
    * Слот аксессуар 1
    * @return integer
    */
    public static $INV_TRINKET_1 = 12;
    /**
    * Слот аксессуар 2
    * @return integer
    */
    public static $INV_TRINKET_2 = 13;
    /**
    * Слот плащ
    * @return integer
    */
    public static $INV_BACK = 14;
    /**
    * Слот левая рука
    * @return integer
    */
    public static $INV_MAIN_HAND = 15;
    /**
    * Слот правая рука
    * @return integer
    */
    public static $INV_OFF_HAND = 16;
    /**
    * Слот дальний бой
    * @return integer
    */
    public static $INV_RANGE = 17;
    /**
    * Слот гербовая накидка (табарда)
    * @return integer
    */
    public static $INV_TABARD = 18;
    /**
    * Массив основных профессий
    * @return array
    */
    public static $GENERAL_PROFESSIONS = [
        164,
        165,
        171,
        197,
        202,
        333,
        755,
        773
    ];
    /**
    * Массив второстепенных профессий
    * @return array
    */
    public static $SECOND_PROFESSIONS = [
        182,
        185,
        186,
        356,
        129,
        393
    ];
    /**
    * Класс воин
    * @return integer
    */
    public static $WARRIOR = 1;
    /**
    * Класс паладин
    * @return integer
    */
    public static $PALADIN = 2;
    /**
    * Класс охотник
    * @return integer
    */
    public static $HUNTER = 3;
    /**
    * Класс разбойник
    * @return integer
    */
    public static $ROGUE = 4;
    /**
    * Класс жрец
    * @return integer
    */
    public static $PRIEST = 5;
    /**
    * Класс рыцарь тьмы
    * @return integer
    */
    public static $DEATHKNIGHT = 6;
    /**
    * Класс шаман
    * @return integer
    */
    public static $SHAMAN = 7 ;
    /**
    * Класс маг
    * @return integer
    */
    public static $MAGE = 8;
    /**
    * Класс чернокнижник
    * @return integer
    */
    public static $WARLOCK = 9;
    /**
    * Класс друид
    * @return integer
    */
    public static $DRUID = 11;
    /**
    * Массив классов
    * @return array
    */
    private static $classes = [
        1 => 'Воин',
        2 => 'Паладин',
        3 => 'Охотник',
        4 => 'Разбойник',
        5 => 'Жрец',
        6 => 'Рыцарь Смерти',
        7 => 'Шаман',
        8 => 'Маг',
        9 => 'Чернокнижник',
        11 => 'Друид'
    ];
    /**
    * Массив расс
    * @return array
    */
    private static $races = [
        1 => 'Человек',
        2 => 'Орк',
        3 => 'Дворф',
        4 => 'Ночной Эльф',
        5 => 'Нежить',
        6 => 'Таурен',
        7 => 'Гном',
        8 => 'Троль',
        10 => 'Кровавый Эльф',
        11 => 'Дреней'
    ];
    /**
    * Массив расс орды
    * @return array
    */
    private static $horde_races = [
        2,
        5,
        6,
        8,
        10
    ];
    /**
    * Массив расс альянса
    * @return array
    */
    private static $alliance_races = [
        1,
        3,
        4,
        7,
        11
    ];
    /**
    * Получить название рассы по индексу
    * @param integer $race_index Индекс рассы
    * @return i18n string
    */
    public static function getRaces($race_index) {return Yii::t('app',$this::$races[$race_index]);}
    /**
    * Получить название класса по индексу
    * @param integer $class_index Индекс класса
    * @return i18n string
    */
    public static function getClasses($class_index) {return Yii::t('app',$this::$classes[$class_index]);}
    /**
    * Проверка является ли расска рассой принадлежащей орде
    * @param integer $race_index Индекс рассы
    * @return bool
    */
    public static function isHordeRace($race_index) {return in_array($race_index,$this::$horde_races) ? true : false;}
    /**
    * Проверка является ли расска рассой принадлежащей альянсу
    * @param integer $race_index Индекс рассы
    * @return bool
    */
    public static function isAllianceRace($race_index) {return in_array($race_index,$this::$alliance_races) ? true : false;}
    /**
    * Правильный порядок символов (глифов) для отображения
    * @return array
    */
    public static function eachGlyphs() {
        return [
            'glyph1',//major
            'glyph4',//major
            'glyph6',//major
            'glyph2',//small
            'glyph3',//small
            'glyph5',//small
        ];
    }
    /**
    * Получить маску класса для армори
    * @param integer $class_index Индекс класса
    * @return integer
    */
    public static function getArmoryClassMask($class_index) {
        switch($class_index) {
            case $this::$WARRIOR:
                return 1;
            case $this::$PALADIN:
                return 2;
            case $this::$HUNTER:
                return 4;
            case $this::$ROGUE:
                return 8;
            case $this::$PRIEST:
                return 16;
            case $this::$DEATHKNIGHT:
                return 32;
            case $this::$SHAMAN:
                return 64;
            case $this::$MAGE:
                return 128;
            case $this::$WARLOCK:
                return 256;
            case $this::$DRUID:
                return 1024;
        }
    }
    /**
    * Получить максиимальный ранг заклинания
    * @param array $spell_data Экземпляр \common\models\armory\ArmoryTalents
    * @return integer
    */
    public static function getMaxRankSpell($spell_data) {
        if($spell_data['Rank_5']) {
            return 5;
        } elseif($spell_data['Rank_4']) {
            return 4;
        } elseif($spell_data['Rank_3']) {
            return 3;
        } elseif($spell_data['Rank_2']) {
            return 2;
        } elseif($spell_data['Rank_1']) {
            return 1;
        } else {
            return 0;
        }
    }
    /**
    * Сортировка массива
    * @param array $array Массив для сортировки
    * @param string $key Опициально - ключ сортировки для вложеных массивов
    * @return array
    */
    public static function quicksort($array, $key = null) {
        if(count($array) < 2) return $array;
        $left = $right = array();
        reset($array);
        $pivot_key  = key($array);
        $pivot  = array_shift($array);
        foreach($array as $k => $v) {
            if($key) {
                if($v[$key] > $pivot[$key]) $left[$k] = $v; else $right[$k] = $v;
            } else {
                if($v > $pivot) $left[$k] = $v; else $right[$k] = $v;
            }
        }
        return array_merge(self::quicksort($left), array($pivot_key => $pivot), self::quicksort($right));
    }
    /**
    * Сформировать ссылку на базу данных.
    * @param integer $id ID элемента
    * @param string $type Тип элемента
    * @return string
    */
    public static function buildDBUrl($id, $type) {return Yii::$app->params['database_url'] . "/$type=$id";}
    /**
    * Сформировать ссылку на картинку рассы (локально).
    * @param integer $race индекс рассы
    * @param integer $gender пол
    * @return string
    */
    public static function buildRaceImageUrl($race, $gender) {return "/img/race/$race-$gender.png";}
    /**
    * Сформировать ссылку на картинку класса (локально).
    * @param integer $class индекс класса
    * @return string
    */
    public static function buildClassImageUrl($class) {return "/img/class/$class.png";}
    /**
    * Сформировать ссылку на иконку в базу данных.
    * @param integer $slot индекс слота
    * @param string $icon_name Опициально - название иконки
    * @return string
    */
    public static function buildItemIconUrl($slot, $icon_name = null) {
        if($icon_name) {
            return Yii::$app->params['database_icon_url'] . "/$icon_name.jpg";
        }
        return "/img/armory/$slot.jpg";
    }
    /**
    * Сформировать значение для rel аттрибута - для отображения доп. эффектов
    * @param integer $itemId ID вещи
    * @param array $data данные о доп. свойствах - \common\models\chars\ItemInstance, поле enchantments пропущеное через explode(' ',field)
    * @return string
    */
    public static function buildItemRel($itemId, $data) {
        $enchat = $data[$this::$ENCHAT_FIELD];
        $socket_1 = $data[$this::$SOCKET_FIELD_1];
        $socket_2 = $data[$this::$SOCKET_FIELD_2];
        $socket_3 = $data[$this::$SOCKET_FIELD_3];
        return "item=$itemId&amp;ench=$enchat&amp;gems=$socket_1:$socket_2:$socket_3";;
    }
    /**
    * Получить текстовое наименование силы класса персонажа
    * @param integer $class_index Индекс класса
    * @return i18n string
    */
    public static function getCharacterPowerByClass($class_index) {
        switch($class_index) {
            case $this::$WARRIOR:
                return Yii::t('app','Ярость:');
            case $this::$ROGUE:
                return Yii::t('app','Энергия:');
            case $this::$DEATHKNIGHT:
                return Yii::t('app','Сила рун:');
            case $this::$MAGE:
            case $this::$PRIEST:
            case $this::$PALADIN:
            case $this::$DRUID:
            case $this::$WARLOCK:
            case $this::$HUNTER:
            case $this::$SHAMAN:
                return Yii::t('app','Мана:');
        }
    }
}