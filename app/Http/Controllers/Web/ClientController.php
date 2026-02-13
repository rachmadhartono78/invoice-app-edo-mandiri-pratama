<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(15);
        $totalClients = Client::count();

        return view('clients.index', compact('clients', 'totalClients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.show', $client)->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }
}
