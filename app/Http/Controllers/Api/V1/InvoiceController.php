<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Validator;

class InvoiceController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        # return InvoiceResource::collection(Invoice::with('user')->get());
        return (new Invoice())->filter($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'max:1', 'in:c,b,p'],
            'paid' => ['required', 'numeric', 'between:0,1'],
            'payment_date' => ['nullable'],
            'value' => ['required', 'numeric', 'between:100,99999.99'],
        ]);

        # Error while validating data
        if ($validator->fails()) {
            return $this->error('Invalid data', 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created)
        {
            # Create and return with relationship
            return $this->response('Invoice created', 200, new InvoiceResource($created->load('user')));
        }

        return $this->error('Invoice not created', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'max:1', 'in:c,b,p'],
            'paid' => ['required', 'numeric', 'between:0,1'],
            'value' => ['required', 'numeric'],
            'payment_date' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ]);

        if ($validator->fails()) {
            return $this->error('Invalid data',422, $validator->errors());
        }

        $validated = $validator->validated();

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'paid' => $validated['paid'],
            'value' => $validated['value'],
            # If was paid, save payment date
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : null,
        ]);

        if ($updated) {
            return $this->response('Invoice updated',200, new InvoiceResource($invoice->load('user')));
        }

        return $this->error('Invoice not updated',400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $deleted = $invoice->delete();

        if ($deleted) {
            return $this->response('Invoice deleted', 200);
        }

        return $this->error('Invoice not deleted',400);
    }
}
