<?php


class PropertyStat extends Eloquent{
        protected $table = 'propertystat';

        protected $fillable = array('view', 'conversation', 'activepushView', 'activemailView');
}
