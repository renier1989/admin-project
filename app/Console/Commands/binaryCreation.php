<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class binaryCreation extends Command
{

    protected $signature = 'laser:update-dates';

    protected $description = 'Comando para actualizar las fechas';

    public function handle()
    {

        /** segunado posible solucion para la actulizacion de las fechas de los documentos */
// Verificar si existen registros sin actualizar en la tabla
$registrosSinActualizar = DB::table('fenasis_laserfiche_documents')
    ->whereNull('fecha_actualizacion')
    ->exists();

if ($registrosSinActualizar) {
    // Obtener los registros a actualizar
    $registros = DB::table('fenasis_laserfiche_documents')
        ->join('fenasis_laserfiche_documents_with_dates', 'fenasis_laserfiche_documents.tocid', '=', 'fenasis_laserfiche_documents_with_dates.tocid')
        ->whereNull('fenasis_laserfiche_documents.fecha_actualizacion')
        ->select('fenasis_laserfiche_documents.id','fenasis_laserfiche_documents.tocid', 'fenasis_laserfiche_documents_with_dates.fecha_creacion', 'fenasis_laserfiche_documents_with_dates.fecha_actualizacion')
        ->get();

    // Agrupar los registros por lotes para la actualización masiva
    $lotes = $registros->chunk(100);

    foreach ($lotes as $lote) {
        $datosActualizacion = [];

        foreach ($lote as $registro) {
            $datosActualizacion[] = [
                'id' => $registro->id,
                'tocid' => $registro->tocid,
                'fecha_creacion' => $registro->fecha_creacion,
                'fecha_actualizacion' => $registro->fecha_actualizacion
            ];
        }

        // Actualizar los registros en lote utilizando updateBatch()
        DB::table('fenasis_laserfiche_documents')
            ->upsert($datosActualizacion, 'id', ['fecha_creacion', 'fecha_actualizacion']);
    }
}

        // /** Primera solucion para la actulizacion de las fechas de los documentos */
        // // Verificar si existen registros sin actualizar en la tabla
        // $registrosSinActualizar = DB::table('fenasis_laserfiche_documents')
        // ->whereNull('fecha_actualizacion')
        // ->exists();

        // if ($registrosSinActualizar) {
        // // Realizar la actualización en lotes
        // DB::table('fenasis_laserfiche_documents')
        //     ->join('fenasis_laserfiche_documents_with_dates', 'fenasis_laserfiche_documents.tocid', '=', 'fenasis_laserfiche_documents_with_dates.tocid')
        //     ->whereNull('fenasis_laserfiche_documents.fecha_actualizacion')
        //     ->orderBy('fenasis_laserfiche_documents.tocid')
        //     ->chunk(2000, function ($registros) {
        //         foreach ($registros as $registro) {
        //             DB::table('fenasis_laserfiche_documents')
        //                 ->where('tocid', $registro->tocid)
        //                 ->update([
        //                     'fecha_creacion' => $registro->fecha_creacion,
        //                     'fecha_actualizacion' => $registro->fecha_actualizacion
        //                 ]);
        //         }
        //     });
        // }

        $this->info("fin del proceso de actualizacion de fechas.");

        // $chunkSize = 2000;

        // DB::table('fenasis_doc_data')->whereNull('storeid_binary')->orderBy('id')->chunk($chunkSize, function($valores){

        //     $bar = $this->output->createProgressBar(count($valores));
        //     $bar->start();

        //     foreach ($valores as $key => $value) {
        //         $num = $value->storeid;
        //         $hex = dechex($num);
        //         $bytes = str_pad($hex, 8, '0', STR_PAD_LEFT);
        //         $varbinary = pack('H*', $bytes);
        //         $valor = bin2hex($varbinary);

        //         DB::table('fenasis_doc_data')->where('id',$value->id)->update([
        //             'storeid_binary' => $valor
        //         ]);

        //             $bar->advance();
        //     }
        //     $bar->finish();
        // });

        // $this->info('Fin del Proceso de actualizacion');

    }
}
