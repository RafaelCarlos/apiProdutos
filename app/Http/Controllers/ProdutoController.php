<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
//Import utilizado para páginação
use Illuminate\Pagination\Paginator;

class ProdutoController extends Controller {

    public function __construct() {
        //Definir que possa ser acessado qualquer método desse Controller.
        header('Acess-Control-Allow-Orign: *');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index() {
//        //Listando registros do BD.
//
//        $produto = Produto::all();
//        return response()->json(['data' => $produto, 'status' => true]);
//    }
    public function index(Request $request) {
        //Listando registros do BD.
        //Quantidade de registros por página
        $qtd = $request['qtd'];

        //Página que queremos visualizar;
        $page = $request['page'];

        //Definindo a página atual
        Paginator::currentPageResolver
                (function () use ($page) {
            return $page;
        });

        $produtos = Produto::paginate($qtd);
        $produtos = $produtos->appends(Request::capture()->except('page'));
        return response()->json(['produtos' => $produtos], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $dados = $request->all();
        $produto = Produto::create($dados);
        if ($produto) {
            return response()->json(['data' => $produto, 'status' => true]);
        } else {
            return response()->json(['data' => 'Erro ao criar o produto', 'status' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //Buscando produto pelo ID
        $produto = Produto::find($id);
        if ($produto) {
            return response()->json(['data' => $produto, 'status' => true]);
        } else {
            return response()->json(['data' => 'Produto não encontrado', 'status' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //Atualizando registro do BD
        $produto = Produto::find($id);
        $dados = $request->all();

        if ($produto) {
            $produto->update($dados);
            return response()->json(['data' => $produto, 'status' => true]);
        } else {
            return response()->json(['data' => 'Erro ao editar produto', 'status' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //Deletando registro
        $produto = Produto::find($id);

        if ($produto) {
            $produto->delete();
            return response()->json(['data' => 'Produto removido com sucesso!', 'status' => true]);
        } else {
            return response()->json(['data' => 'Não foi possível remover o produto!', 'status' => false]);
        }
    }

}
