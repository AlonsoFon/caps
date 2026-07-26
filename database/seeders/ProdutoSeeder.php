<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            'LUVA DE LÁTEX G',
            'LUVA DE LÁTEX P',
            'LUVA NITRILICA P',
            'LUVA NITRILICA M',
            'MÁSCARA KN95',
            'XILOL PA 5L',
            'FORMOL 37% INIBIDO 5L',
            'ÁLCOOL ETÍLICO ANIDRO 99,5º 5L',
            'ÁLCOOL ETÍLICO ANIDRO 99,5º 20L',
            'HEMATOXILINA DE HARRIS 1L',
            'HEMATOXILINA DE HARRIS 5L',
            'EOSINA AMARELADA 0,5% 1L',
            'EOSINA AMARELADA 0,5% 5L',
            'NAVALHA PERFIL ALTO MICROBLADE',
            'NAVALHA PERFIL ALTO LEICA',
            'NAVALHA PERFIL ALTO DURAEDGE',
            'LAMÍNULAS 24X60 mm C/100',
            'LÂMINAS SILANIZADAS',
            'LÂMINAS PONTA FOSCA C/50 UNID',
            'FILTRO BIÓPSIA AZUL',
            'PAPEL P/ PROCESSAMENTO FRAG PEQUENOS',
            'CASSETES HISTOLÓGICOS VERDES',
            'CASSETES HISTOLÓGICOS BRANCOS',
            'PONTEIRA TIPO GILSON 200 ul',
            'PONTEIRAS TIPO EPPENDORF 200 ul',
            'RESINA ACRILICA MONTAGEM DE LÂMINAS',
            'GEL PARA CONGELAÇÃO KILLIK',
            'COLA SILICONE LÍQUIDA',
            'EASYDESC SOFT',
            'FILTRO DUPLO DE MEMBRANA GYNOPREP',
            'KIT SOLUÇÃO PARA CONSERVAÇÃO CELULAR',
            'ROLO ADESIVO PARA IMPRESSORA ZEBRA',
            'ETIQUETAS DE IDENTIFICAÇÃO PARA FRASCOS',
            'LAMINULA 24X50 mm C/100',
            'TINTA IMPRESSORA ZEBRA RESISTENTE',
            'FITA ADESIVA 48MM',
            'FITA ADESIVA 12 MM',
            'HISTOBOX CASSETES',
            'PINCEL PEQUENO',
            'GRAMPOS PARA GRAMPEADOR',
            'POST IT',
            'MARCADOR PARA CD - AZUL',
            'MARCADOR PARA CD - VERMELHO',
            'LÁPIS 2B',
            'LÁPIS 2HB',
            'CADERNO PEQUENO',
            'CADERNO GRANDE',
            'HISTOBOX LÂMINAS',
            'ALMOTOLIA 500 ML PISSETA',
            'EA36 CITOLOGIA',
            'ORANGE CITOLOGIA',
            'PAPEL A4',
            'LUVAS DE LÁTEX G',
            'LUVAS NITRÍLICAS P',
            'PARAFINA 10 KG',
            'PERFLEX',
            'GIEMSA',
        ];

        foreach ($produtos as $produtoNome) {
            Produto::query()->updateOrInsert(
                ['name' => $produtoNome],
                [
                    'descricao' => $produtoNome,
                    'quantidade_minima' => 1,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
