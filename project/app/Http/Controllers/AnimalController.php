<?php

namespace App\Http\Controllers;

use App\Animal;
use App\Pessoa;
use Illuminate\Http\Request;
use PessoaSeeder;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animal = Animal::all();
        return view('animal.index', compact('animais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {   
        $pessoa = Pessoa::findOrFail($id);
        return view('animal.create' , compact('pessoa'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {   
        //dd($request);
        $pessoa = Pessoa::findOrFail($id);
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'especie' => 'required|max:255',
            'raca' => 'required|max:255',
            'corDaPelagem' => 'required|max:255',
            'idade' => 'required|max:255',
            'porteFisico' => 'required|max:255',
            'comportamento' => 'required|max:10',
            'vacinado' => 'required|max:255',
        ]);
        //dd($validatedData);
            //dd ($pessoa->animais);
        //array_push($pessoa->animais, $validatedData);
        $animal = new Animal;
        
        //$animal = $validatedData;
        $animal->pessoa_id = $id;
        $animal->nome = $request->input('nome');
        $animal->especie = $request->input('nome');
        $animal->raca = $request->input('raca');
        $animal->corDaPelagem = $request->input('corDaPelagem');
        $animal->idade = $request->input('idade');
        $animal->porteFisico = $request->input('porteFisico');
        $animal->comportamento = $request->input('comportamento');
        $animal->vacinado = $request->input('vacinado');
        $animal->save();
        // dd($animal);
        $pessoa->animais->push($animal);
        //dd ($pessoa->animais);
        $pessoa->save();
        //Pessoa::whereId($pessoa->id)->update($validatedData);
        return redirect(route('pessoa.index'))->with('success', 'Alumnus is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $animal = Animal::findOrFail($animal->id);
        return view('animal.edit', compact('animal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Animal $animal)
    {
        $validatedData = $request->validate([
            'nome' => 'max:255',
            'especie' => 'max:255',
            'raca' => 'max:255',
            'corDaPelagem' => 'max:255',
            'idade' => 'max:255',
            'porteFisico' => 'max:255',
            'comportamento' => 'max:10'    ,
            'vacinado' => 'max:255'
        ]);
        Animal::whereId($animal->id)->update($validatedData);
        return redirect(route('animal.index'))->with('success', 'Alumnus is successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Animal  $animal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal = Animal::findOrFail($animal->id);
        $animal->delete();
        return redirect(route('animal.index'))->with('success', 'Animal is successfully deleted');
    }
}
