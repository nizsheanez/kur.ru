<?
Yii::import('zii.widgets.CPortlet');

/**
 * @property string $assets
 */
class Portlet extends CPortlet
{
    public function init()
    {
        $this->attachBehaviors($this->behaviors());
        parent::init();
    }


    public function behaviors()
    {
        return array(
            'CoomponentInModule' => array(
                'class' => 'application.components.behaviors.ComponentInModuleBehavior'
            )
        );
    }
}
