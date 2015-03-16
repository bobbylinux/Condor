<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model {

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'data_creazione';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'data_modifica';

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'data_cancellazione';

    /**
     * The array containing the names of database columns that can't be edited/inserted on storage
     * 
     */
    protected $guarded = array('id', 'data_creazione', 'data_modifica');
    
    protected $messages = array(
       
    );  

}
