<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimuladorController extends Controller
{
    private $dadosSimulador;
    private $simulacao = [];

    public function simular(Request $request)
    {
        $this->carregarArquivoDadosSimulador()
             ->simularEmprestimo($request->valor_emprestimo)
             ->filtrarInstituicao($request->instituicoes)
             ->filtrarParcelas($request->parcela)
             ->filtrarConvenios($request->convenios)
        ;
        return \response()->json($this->simulacao);
    }

    //to test
    /*public function simular2(Request $request)
    {
        $this->carregarArquivoDadosSimulador()
             ->simularEmprestimo($request->valor_emprestimo)
             ->filtrarInstituicao($request->instituicoes)
             ->filtrarParcelas($request->parcela)
             ->filtrarConvenios($request->convenios)
        ;

        return \response()->json($this->simulacao);
    }*/

    private function carregarArquivoDadosSimulador() : self
    {
        $this->dadosSimulador = json_decode(\File::get(storage_path("app/public/simulador/taxas_instituicoes.json")));
        return $this;
    }

    private function simularEmprestimo(float $valorEmprestimo) : self
    {
        foreach ($this->dadosSimulador as $dados) {
            $this->simulacao[$dados->instituicao][] = [
                "taxa"            => $dados->taxaJuros,
                "parcelas"        => $dados->parcelas,
                "valor_parcela"    => $this->calcularValorDaParcela($valorEmprestimo, $dados->coeficiente),
                "convenio"        => $dados->convenio,
            ];
        }
        return $this;
    }

    private function calcularValorDaParcela(float $valorEmprestimo, float $coeficiente) : float
    {
        return round($valorEmprestimo * $coeficiente, 2);
    }

    private function filtrarInstituicao(array $instituicoes) : self
    {
        if (\count($instituicoes))
        {
            $arrayAux = [];
            foreach ($instituicoes AS $key => $instituicao)
            {
                if (\array_key_exists($instituicao, $this->simulacao))
                {
                     $arrayAux[$instituicao] = $this->simulacao[$instituicao];
                }
            }
            $this->simulacao = $arrayAux;
        }
        return $this;
    }

    #novos filtros - private functions
    /*private function filtrarConvenio(array $convenios) : self
    {
        if (\count($convenios))
        {
            $arrayAux = [];
            foreach ($convenios AS $key => $convenio)
            {
                if (\array_filter($convenio, $this->convenio))
                {
                     $arrayAux[$convenio] = $this->simulacao[$instituicao];
                }
            }
            $this->simulacao = $arrayAux;
        }
        return $this;
    }
    */
    private function filtrarParcelas(int $parcelas) : self
    {
        $parcela = $parcelas;
        foreach($this->simulacao AS $key=>$s) {
            foreach($s AS $i => $ss) {

                if($ss['parcelas'] != $parcela) {
                    unset($this->simulacao[$key][$i]);
                }
            }            
        }
        return $this;
    }

    private function filtrarConvenios(array $convenios) : self
    {
        $convenio = $convenios;
        foreach($this->simulacao AS $key=>$s) {
            foreach($s AS $i => $ss) {
                if (!in_array($ss['convenio'], $convenio)) {

                    unset($this->simulacao[$key][$i]);
                }
            }            
        }
        return $this;
    }

    

}
