<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Filament\Resources\ExperienceResource\RelationManagers;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('company_name')
                    ->label('Company/Insitution Name')
                    ->required(),
                ColorPicker::make('icon_bg')
                    ->label('Image Background Color')
                    ->required(),
                TextInput::make('date')->required(),
                FileUpload::make('icon_url')
                    ->label('Image')
                    ->disk('s3')
                    ->directory('experience-images')
                    ->image()
                    ->visibility('public')
                    ->required(),
                Repeater::make('descriptions')
                    ->relationship('descriptions')
                    ->schema([
                        Textarea::make('description')
                        ->autosize(true)
                        ->required(),
                    ])
                    ->columns(1)
                    ->columnSpan(2)
                    ->grid(2)
                    ->addActionLabel('Add Description')
                    ->minItems(1)
                    ->reorderable()
                    ->reorderableWithButtons(true)
                    ->orderColumn('order')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('company_name'),
                Tables\Columns\ImageColumn::make('icon_url')
                    ->label('Icon'),
                Tables\Columns\TextColumn::make('icon_bg'),
                Tables\Columns\TextColumn::make('date'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc');;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
