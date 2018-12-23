<?php
namespace core\components\helpers;

use Yii;
use yii\base\Component;
use yii\helpers\Html;

class Armory extends Component
{
    /**
     * Type item
     * @return string
     */
    const TYPE_ITEM = 'item';
    /**
     * Type quest
     * @return string
     */
    const TYPE_QUEST = 'quest';
    /**
     * Type spell
     * @return string
     */
    const TYPE_SPELL = 'spell';
    /**
     * Type achievement
     * @return string
     */
    const TYPE_ACHIEVEMENT = 'achievement';
    /**
     * Array of allowed item slots for character
     * @return array
     */
    const SLOTS = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
    /**
     * Inventory index for head
     * @return integer
     */
    const INV_HEAD = 0;
    /**
     * Inventory index for neck
     * @return integer
     */
    const INV_NECK = 1;
    /**
     * Inventory index for shoulder
     * @return integer
     */
    const INV_SHOULDER = 2;
    /**
     * Inventory index for shirt
     * @return integer
     */
    const INV_SHIRT = 3;
    /**
     * Inventory index for chest
     * @return integer
     */
    const INV_CHEST = 4;
    /**
     * Inventory index for waist(belt)
     * @return integer
     */
    const INV_BELT = 5;
    /**
     * Inventory index for legs
     * @return integer
     */
    const INV_LEGS = 6;
    /**
     * Inventory index for boots
     * @return integer
     */
    const INV_BOOTS = 7;
    /**
     * Inventory index for wrist
     * @return integer
     */
    const INV_WRIST = 8;
    /**
     * Inventory index for gloves
     * @return integer
     */
    const INV_GLOVES = 9;
    /**
     * Inventory index for ring_1
     * @return integer
     */
    const INV_RING_1 = 10;
    /**
     * Inventory index for ring_2
     * @return integer
     */
    const INV_RING_2 = 11;
    /**
     * Inventory index for trinket_1
     * @return integer
     */
    public const INV_TRINKET_1 = 12;
    /**
     * Inventory index for trinket_2
     * @return integer
     */
    public const INV_TRINKET_2 = 13;
    /**
     * Inventory index for clock
     * @return integer
     */
    const INV_BACK = 14;
    /**
     * Inventory index for main-hand
     * @return integer
     */
    const INV_MAIN_HAND = 15;
    /**
     * Inventory index for off-hand
     * @return integer
     */
    const INV_OFF_HAND = 16;
    /**
     * Inventory index for range weapon
     * @return integer
     */
    const INV_RANGE = 17;
    /**
     * Inventory index for tabard
     * @return integer
     */
    const INV_TABARD = 18;
    /**
     * Class warrior
     * @return integer
     */
    const CLASS_WARRIOR = 1;
    /**
     * Class paladin
     * @return integer
     */
    const CLASS_PALADIN = 2;
    /**
     * Class hunter
     * @return integer
     */
    const CLASS_HUNTER = 3;
    /**
     * Class rogue
     * @return integer
     */
    const CLASS_ROGUE = 4;
    /**
     * Class priest
     * @return integer
     */
    const CLASS_PRIEST = 5;
    /**
     * Class death-knight
     * @return integer
     */
    const CLASS_DEATHKNIGHT = 6;
    /**
     * Class shaman
     * @return integer
     */
    const CLASS_SHAMAN = 7 ;
    /**
     * Class mage
     * @return integer
     */
    const CLASS_MAGE = 8;
    /**
     * Class warlock
     * @return integer
     */
    const CLASS_WARLOCK = 9;
    /**
     * Class druid
     * @return integer
     */
    const CLASS_DRUID = 11;
    /**
     * Array classes
     * @return array
     */
    const CLASSES = [
        1  => 'Warrior',
        2  => 'Paladin',
        3  => 'Hunter',
        4  => 'Rogue',
        5  => 'Priest',
        6  => 'Death knight',
        7  => 'Shaman',
        8  => 'Mage',
        9  => 'Warlock',
        11 => 'Druid'
    ];
    /**
     * Массив расс
     * @return array
     */
    const RACES = [
        1  => 'Human',
        2  => 'Orc',
        3  => 'Dwarf',
        4  => 'Night elf',
        5  => 'Undead',
        6  => 'Tauren',
        7  => 'Gnome',
        8  => 'Troll',
        10 => 'Blood elf',
        11 => 'Draenei'
    ];
    /**
     * HORDE RACES
     * @return array
     */
    const HORDE_RACES = [
        2,
        5,
        6,
        8,
        10
    ];
    /**
     * ALLIANCE RACES
     * @return array
     */
    const ALLIANCE_RACES = [
        1,
        3,
        4,
        7,
        11
    ];

    /**
     * Build tag <img /> for race based on raceIndex & gender
     * @param $race
     * @param $gender
     * @return string
     */
    public static function buildTagRaceImage($race, $gender)
    {
        return Html::img(self::buildPathToRaceImage($race,$gender),[
            'class'          => 'armory-icon armory-race-icon tltp',
            'data-toggle'    => 'tooltip',
            'data-placement' => 'bottom',
            'title'          => self::getRaceName($race),
            'alt'            => self::getRaceName($race)
        ]);
    }

    /**
     * Build path to race image
     * @param integer $race raceIndex
     * @param integer $gender gender
     * @return string
     */
    public static function buildPathToRaceImage($race, $gender)
    {
        //TODO - get bundle and make path to image
        return "/resources/images/race/$race-$gender.png";
    }

    /**
     * Build tag <img /> for class based on classIndex.
     * @param integer $class classIndex
     * @return string
     */
    public static function buildTagClassImage($class)
    {
        return Html::img(self::buildPathToClassImage($class),[
            'class'          => 'armory-icon armory-class-icon tltp',
            'data-toggle'    => 'tooltip',
            'data-placement' => 'bottom',
            'title'          => self::getClassName($class),
            'alt'            => self::getClassName($class)
        ]);
    }

    /**
     * Build path to class image
     * @param integer $class class index
     * @return string
     */
    public static function buildPathToClassImage($class)
    {
        //TODO - get bundle and make path to image
        return "/resources/images/class/$class.png";
    }

    /**
     * Get race name by index
     * @param integer $raceIndex
     * @return string
     */
    public static function getRaceName($raceIndex)
    {
        return Yii::t('armory',self::RACES[$raceIndex]);
    }

    /**
     * Get class name by index
     * @param integer $classIndex class index
     * @return string
     */
    public static function getClassName($classIndex)
    {
        return Yii::t('armory',self::CLASSES[$classIndex]);
    }

    /**
     * Check is horde race by race index
     * @param integer $raceIndex
     * @return bool
     */
    public static function isHordeRace($raceIndex)
    {
        return in_array($raceIndex,self::HORDE_RACES, true) ? true : false;
    }

    /**
     * Check is alliance race by race index
     * @param integer $raceIndex
     * @return bool
     */
    public static function isAllianceRace($raceIndex)
    {
        return in_array($raceIndex,self::ALLIANCE_RACES, true) ? true : false;
    }
}