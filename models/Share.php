<?php

namespace app\models;

use Yii;
use yii\base\Model;


// Работа со списком
class Share extends \yii\db\ActiveRecord
{

    public $remove;
    
    public static function tableName()
    {
        return 'share';
    }
    
    public function rules()
    {
        return [
            [['share'], 'required'],
            [['remove'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id'        => 'Id',
            'id_user'   => 'Id_user',
            'share'     => 'Share'
        ];
    }
    
    public function getShare()
    {   
        
        return $this->find()->where(array('id_user'=>Yii::$app->user->id))->all();
    }
    
    public function add()
    { 
        $this->id_user = Yii::$app->user->id;
   
        return $this->save() ? true : false;
    }
    
    public function remove()
    {
        
        return $this->deleteAll('id_user = ' . Yii::$app->user->id);
    }
    
    
    
}