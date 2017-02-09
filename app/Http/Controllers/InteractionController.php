<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InteractionController extends Controller
{
    //
    public function interactive(Request $request)
    {
        $payload = json_decode($request->request->get('payload'));

        switch ($payload->callback_id) {
            case 'update_cycle':
                $applier = new InteractionCallbacks\UpdateCycle($payload);
                $applier->apply();
                break;
        }
    }
}
