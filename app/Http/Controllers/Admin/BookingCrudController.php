<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Booking;

/**
 * Class BookingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Booking::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/booking');
        CRUD::setEntityNameStrings('booking', 'bookings');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('consignee');
        CRUD::column('driver');
        CRUD::column('tracking_num');
        CRUD::column('amount');
        CRUD::column('reference_num');
        CRUD::column('pickup_date');
        CRUD::column('delivery_date');
        CRUD::column('status');
        CRUD::addClause('where', 'user_id', backpack_user()->id);
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
        CRUD::setValidation(BookingRequest::class);

        CRUD::addField([
            'name' => 'consignee',
            'type' => 'relationship',
            'hint' => 'Click <a href="/admin/consignee/create">here</a> to add new consignees',
            'options'   => (function ($query) {
                return $query->where('user_id', backpack_user()->id)->get();
            }),
        ]);
        CRUD::addField([
            'name' => 'amount',
            'type' => 'number',
            'decimals' => 2,
            'attributes' => ["step" => "any"],
        ]);
        CRUD::addField([
            'name' => 'weight',
            'label' => 'Weight (kg)',
            'type' => 'number',
            'decimals' => 2,
            'attributes' => ["step" => "any"],
        ]);
        CRUD::addField([
            'name' => 'no_pieces',
            'type' => 'number',
        ]);
        CRUD::field('reference_num');
        CRUD::addField([
            'name' => 'pickup_date',
            'type' => 'date'
        ]);
        CRUD::field('notes');
        CRUD::addField([
            'name' => 'status',
            'type' => 'hidden',
            'default' => 'Created'
        ]);
        CRUD::addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'default' => backpack_user()->id
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
        CRUD::setValidation(BookingRequest::class);
        $booking_id = request()->route('id');
        $user_id = Booking::find($booking_id)->user_id;

        $disabled = (backpack_user()->hasRole('Super Admin') && $user_id != backpack_user()->hasRole('Super Admin')) ? 'disabled' : '';

        CRUD::addField([
            'name' => 'consignee',
            'type' => 'relationship',
            'hint' => 'Click <a href="/admin/consignee/create">here</a> to add new consignees',
            'options'   => (function ($query) {
                return $query->where('user_id', backpack_user()->id)->get();
            }),
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'amount',
            'type' => 'number',
            'decimals' => 2,
            'attributes' => ["step" => "any"],
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'weight',
            'label' => 'Weight (kg)',
            'type' => 'number',
            'decimals' => 2,
            'attributes' => ["step" => "any"],
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'no_pieces',
            'type' => 'number',
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'reference_num',
            'type' => 'text',
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'pickup_date',
            'type' => 'date',
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'notes',
            'type' => 'textarea',
            'attributes' => [
                $disabled  => $disabled,
            ],
        ]);
        CRUD::addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'default' => backpack_user()->id
        ]);

        if(backpack_user()->hasRole('Super Admin')) {
            CRUD::addField([
                'name' => 'delivery_date',
                'type' => 'date',
            ]);

            CRUD::addField([
                'name' => 'status',
                'type'        => 'select_from_array',
                'options'     => [
                    'For Pickup' => 'For Pickup',
                    'For Delivery' => 'For Delivery',
                    'Delivered' => 'Delivered',
                    'Cancelled' => 'Cancelled'
                ],
            ]);

            CRUD::addField([
                'name' => 'tracking_num',
                'type' => 'text',
            ]);

            CRUD::addField([
                'name' => 'notes_admin',
                'type'        => 'textarea',
                'label' => 'Admin Notes'
            ]);
        }
    }

    protected function setupShowOperation()
    {
        CRUD::addColumn([
            'name'         => 'consignee',
            'type'         => 'relationship',
            'label'        => 'Consignee Name',
        ]);
        CRUD::addColumn([
            'name'         => 'consignee_address',
            'type'         => 'text',
            'label'        => 'Consignee Address',
        ]);
        CRUD::addColumn([
            'name'         => 'consignee_emirate',
            'type'         => 'text',
            'label'        => 'Consignee Emirate',
        ]);
        CRUD::addColumn([
            'name'         => 'consignee_phone',
            'type'         => 'text',
            'label'        => 'Consignee Phone',
        ]);

        CRUD::addColumn([
            'name'         => 'reference_num',
            'type'         => 'text',
            'label'        => 'Reference Number',
        ]);
        CRUD::addColumn([
            'name'         => 'pickup_date',
            'type'         => 'text',
            'label'        => 'Pickup Date',
        ]);
        CRUD::addColumn([
            'name'         => 'amount',
            'type'         => 'text',
            'label'        => 'Amount',
        ]);
        CRUD::addColumn([
            'name'         => 'no_pieces',
            'type'         => 'text',
            'label'        => 'No of Pieces',
        ]);
        CRUD::addColumn([
            'name'         => 'weight',
            'type'         => 'text',
            'label'        => 'Weight (kg)',
        ]);
        CRUD::addColumn([
            'name'         => 'notes',
            'type'         => 'text',
            'label'        => 'Notes',
        ]);

        CRUD::addColumn([
            'name'         => 'status',
            'type'         => 'text',
            'label'        => 'Delivery Status',
        ]);
        CRUD::addColumn([
            'name'         => 'tracking_num',
            'type'         => 'text',
            'label'        => 'Tracking Number',
        ]);
        CRUD::addColumn([
            'name'         => 'delivery_date',
            'type'         => 'text',
            'label'        => 'Delivery Date',
        ]);
    }
}
