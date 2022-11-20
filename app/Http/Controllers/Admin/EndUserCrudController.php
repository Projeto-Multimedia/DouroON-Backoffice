<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EndUserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EndUserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EndUserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\EndUser::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/end-user');
        CRUD::setEntityNameStrings('end user', 'end users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'avatar',
            'label' => 'Avatar',
            'type' => 'image',
            'height' => '40px',
            'width'  => '40px',
        ]);
        CRUD::column('name');
        CRUD::column('username');
        CRUD::column('email');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EndUserRequest::class);

        CRUD::addField([
            'name' => 'avatar',
            'label' => 'Avatar',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'uploads',
        ]);
        CRUD::field('name');
        CRUD::field('username');
        CRUD::field('email');
       
        CRUD::addField([
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password',
        ]);
        
        CRUD::field('token')->type('hidden');

        CRUD::addField([
            'name' => 'profile',
            'value' => 'company',
            'type' => 'hidden',
        ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
