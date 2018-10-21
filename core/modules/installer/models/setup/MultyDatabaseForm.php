<?php
namespace core\modules\installer\models\setup;

use Yii;
use yii\base\Model;

/**
 * MultyDatabaseForm holds all required database settings.
 */
class MultyDatabaseForm extends Model
{

    public $_name = 'Default name';
    public $dbs = [];
    
    public function setDefault() {
        $this->dbs = [
            (new DatabaseForm())
        ];
    }
    
    public function rules()
    {
        return [
            [['dbs'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'dbs' => Yii::t('installer','Databases')
        ];
    }

    public function load($dbs,$formName = null) {
        if(!$dbs) return false;
        $this->dbs = [];
        foreach($dbs as $db) {
            $this->dbs[] = new DatabaseForm($db);
        }
        return true;
    }

}