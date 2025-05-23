<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriesResource\Pages;
use App\Models\Categories;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class CategoriesResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Informasi Produk';
    protected static ?string $pluralModelLabel = 'Kategori Produk';

    public static function getModelLabel(): string
    {
        return 'Kategori Produk';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->live(onBlur: true)
                    ->reactive()
                    ->unique(ignoreRecord: true)
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Nama kategori harus diisi.',
                        'unique' => 'Nama kategori sudah ada.',
                    ]),

                Textarea::make('description')
                    ->label('Deskripsi Kategori')
                    ->live(onBlur: true)
                    ->reactive()
                    ->rules('required')
                    ->validationMessages(['required' => 'Deskripsi kategori harus diisi.',]),

                FileUpload::make('image')
                    ->label('Gambar Kategori')
                    ->image()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->limit(100),

                ImageColumn::make('image')
                    ->label('Gambar Kategori')
                    ->url(fn ($record) => $record->image ? asset('storage/' . $record->image) : null),

                TextColumn::make('products_count')
                    ->label(label: 'Jumlah Produk')
                    ->counts('products') // Ini fitur keren dari Filament
                    ->sortable(),
                // ->getRelationshipsToCount(),
            ])
            ->filters([
                // Filter bisa ditambahkan di sini jika diperlukan
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Produk')
                    ->icon('heroicon-o-trash') // kamu bisa ganti iconnya
                    ->color('danger') // pilihan: primary, secondary, success, warning, danger
                    ->requiresConfirmation() // tampilkan dialog konfirmasi
                    ->modalHeading('Hapus Produk yang Dipilih?')
                    ->modalSubheading('Tindakan ini tidak bisa dibatalkan. Lanjutkan?')
                    ->modalButton('Ya, Hapus') // teks tombol dalam modal,
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            // Relation manager jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategories::route('/create'),
            'edit' => Pages\EditCategories::route('/{record}/edit'),
        ];
    }
}
