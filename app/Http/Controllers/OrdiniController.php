<?php

namespace App\Http\Controllers;

use App\Models\DettaglioOrdine;
use App\Models\Ordini;
use Illuminate\Http\Request;

class OrdiniController extends Controller
{
    /**
     * Recupera tutti gli ordini
     */
    public function show(){
        $ordini = Ordini::select('ordini.id', 'partner.titolo AS partner', 'clienti.nome', 'clienti.cognome', 'totale')
                            ->join('partner', 'partner.external_id', '=', 'ordini.id_partner')
                            ->join('clienti', 'clienti.id', '=', 'ordini.id_cliente')
                            ->whereNull('ordini.deleted_at')
                            ->get();

        return view('ordini.show')
                ->withOrdini($ordini);
    }

    /**
     * Mostra il dettaglio di un ordine
     */
    public function detail($idOrdine){
        $ordine = Ordini::select('ordini.id', 'ordini.created_at', 'partner.titolo AS partner', 'partner.external_id AS ext_id_partner', 'clienti.nome', 'clienti.cognome', 'totale')
                            ->join('partner', 'partner.external_id', '=', 'ordini.id_partner')
                            ->join('clienti', 'clienti.id', '=', 'ordini.id_cliente')
                            ->where('ordini.id', $idOrdine)
                            ->first();

        $dettaglioOrdine = DettaglioOrdine::select('prodotti.titolo AS prodotto', 'prodotti_partner.prezzo AS prezzo')
                            ->join('prodotti_partner', 'prodotti_partner.prodotto_id', '=', 'dettaglio_ordine.id_prodotto')
                            ->join('prodotti', 'prodotti.external_id', '=', 'dettaglio_ordine.id_prodotto')
                            ->where('dettaglio_ordine.id_ordine', $idOrdine)
                            ->where('prodotti_partner.partner_id', $ordine->ext_id_partner)
                            ->get();

        return view('ordini.detail')
                ->withOrdine($ordine)
                ->withDettaglioOrdine($dettaglioOrdine);
    }
}
