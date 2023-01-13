<?php

namespace App\Traits;

trait DenyAccessTrait
{
    protected function setupAccess()
    {
        if (!backpack_user()->hasRole('admin') || !backpack_user()->hasRole('moderator')) {
            $this->crud->denyAccess('create');
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('delete');
        }
        
    }

    protected function setupViewAccess()
    {
        if (!backpack_user()->hasRole('admin') && !backpack_user()->hasRole('moderator')) {
            $this->crud->denyAccess('list');
            $this->crud->denyAccess('show');
        }
        
    }

    protected function setupAdminViewAccess()
    {
        if (!backpack_user()->hasRole('admin')) {
            $this->crud->denyAccess('list');
            $this->crud->denyAccess('show');
        }
        
    }
    
    protected function setupDenyDelete()
    {
            $this->crud->denyAccess('delete');   
    }

    protected function setupDeny()
    {
            $this->crud->denyAccess('create');
            $this->crud->denyAccess('update'); 
    }

    protected function RemoveActionColumn()
    {     
            $this->crud->removeAllButtonsFromStack('line');
    }

}