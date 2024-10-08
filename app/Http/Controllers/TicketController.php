<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Flight;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Tickets Management OpenAPI Documentation",
 *      description="Laravel Swagger OpenAPI"
 * )
 */
class TicketController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/tickets",
    *     summary="Get list of all booked tickets",
    *     tags={"Tickets"},
    *     @OA\Response(response="200", description="Successful operation")
    * )
    */
    public function index()
    {
        $tickets = Ticket::with('flight')->get();
        $enrichedTickets = $tickets->map(function ($ticket) {
            return [
                'id' => $ticket->id,
                'flight_id' => $ticket->flight_id,
                'passenger_name' => $ticket->passenger_name,
                'passport' => $ticket->passport,
                'price'=> $ticket->flight->price,
                'seat' => $ticket->seat,
                'source_airport' => $ticket->flight->source_airport,
                'destination_airport' => $ticket->flight->destination_airport,
            ];
        });
        return response()->json($enrichedTickets);
    }

    /**
     * @OA\Post(
     *     path="/api/tickets",
     *     summary="Create a new ticket",
     *     tags={"Tickets"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"flight_id","passenger_name","passport"},
     *             @OA\Property(property="flight_id", type="string", maxLength=255),
     *             @OA\Property(property="passenger_name", type="string", maxLength=255),
     *             @OA\Property(property="passport", type="string", maxLength=255),
     *             @OA\Property(property="seat", type="string", maxLength=255, nullable=true),
     *         )
     *     ),
     *     @OA\Response(response="201", description="Ticket created successfully"),
     *     @OA\Response(response="422", description="Validation error")
     * )
    */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'flight_id' => 'required|string|max:255',
            'passenger_name' => 'required|string|max:255',
            'passport' => 'required|string|max:255',
            'seat' => 'nullable|string|max:255',
            // Add other validation rules as needed
        ]);
    
        if (empty($validatedData['seat'])) {
            $seatNumber = rand(1, 32);
            $seatLetter = ['A', 'B', 'C', 'D'][rand(0, 3)];
            $validatedData['seat'] = $seatNumber . $seatLetter;
        }
    

        $ticket = Ticket::create($validatedData);

        return response()->json($ticket, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/tickets/reset",
     *     summary="Reset tickets to default demo data",
     *     tags={"Tickets"},
     *     @OA\Response(
     *         response=200,
     *         description="Table reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Table reset successfully")
     *         )
     *     )
     * )
     */
    public function reset(Request $request)
    {
        Ticket::truncate();
        Artisan::call('db:seed', ['--class' => 'TicketsSeeder']);
        return response()->json(['message' => 'Table reset successfully']);
    }

    /**
     * @OA\Put(
     *     path="/api/tickets/{id}",
     *     summary="Update seat for ticket",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Ticket ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="seat", type="string", example="12A")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Seat updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ticket")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'seat' => [
                'required',
                'string',
                'between:2,3',
                function ($attribute, $value, $fail) {
                    $number = substr($value, 0, -1);
                    $letter = strtoupper(substr($value, -1));
                    
                    if (!is_numeric($number) || $number < 1 || $number > 32) {
                        $fail('The first two characters must be a number between 01 and 32.');
                    }
                    
                    if (!in_array($letter, ['A', 'B', 'C', 'D'])) {
                        $fail('The last character must be A, B, C, or D.');
                    }
                },
            ],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->seat = $request['seat'];
        $ticket->save();

        return response()->json($ticket);
    }

    /**
     * Set status of a tickets as canceled
     */
    public function cancel(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'canceled';
        $ticket->save();

        return response()->json($ticket);
    }

    /**
     * @OA\Delete(
     *     path="/api/tickets/{id}",
     *     summary="Delete a ticket",
     *     tags={"Tickets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Ticket ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Ticket deleted successfully"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(null, 204);
    }
}
