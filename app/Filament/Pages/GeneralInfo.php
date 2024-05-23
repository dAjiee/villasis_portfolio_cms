<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

use App\Models\GeneralInfo as GeneralInfoModel;

class GeneralInfo extends Page
{   
    use InteractsWithForms;
    
    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.general-info';

    public function mount(){
        // Load the first row of the general-info table
        $generalInfo = GeneralInfoModel::first();

        if ($generalInfo) {
            // Fill the form with the data
            $this->form->fill($generalInfo->toArray());
        }
    }

    public function getFormSchema(): array {
        return [
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('about_description')->label('About Description')->autosize(true)->required(),
            Textarea::make('leadership_description')->label('Leadership Description')->autosize(true)->required(),
            Textarea::make('projects_description')->label('Projects Description')->autosize(true)->required()];
    }

    public function form(Form $form):Form{
        return $form->schema($this->getFormSchema())->statePath('data');
    }

    protected function getFormActions(): array {
        return [
            Action::make('save')->submit('save'),
        ];
    }

    public function save() {
        try {
            // Retrieve the form state
            $data = $this->form->getState();
            $generalInfo = GeneralInfoModel::first();
            $generalInfo->fill($data);
            $generalInfo->save();

            Notification::make()->title('Saved successfully!')->success()->send();
        } catch (\Throwable $ex) {
            Notification::make()->title('Something went wrong!')->danger()->send();
            return;
        }
    }
}
