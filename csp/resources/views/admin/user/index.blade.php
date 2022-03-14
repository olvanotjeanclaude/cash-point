@extends('layouts.app')

@section('title')
    Liste des Utilisateurs
@endsection

@section('css')
    <x-datatable-css-link />
@endsection

@section('content')
    <!-- start page title -->
    @include('includes.page-title-box', [
        'pageTitle' => 'Utilisateurs',
        'pageDescription' => 'Les utilisateurs enregistrés dans le système sont répertoriés ici',
        'action' => 'Nouvel utilisateur',
        'icon' => 'fas fa-user-plus',
        'link' => '#',
    ])
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <x-loading-component :head="['Rôle','Status','Nom Et Prénom','E-mail','Date d\'ajout','Action']">
                @foreach ($users as $user)
                    <tr id="row_{{ $user->id }}">
                        <td>
                            @switch($user->permission)
                                @case(1)
                                    <label class="badge bg-light">Admin </label>
                                    <span>{{ get_user_id() == $user->id ? '(Benim)' : '' }}</span>
                                @break

                                @case(2)
                                    <label class="badge bg-primary">Manager</label>
                                @break

                                @case(3)
                                    <label class="badge bg-warning">Personel</label>
                                @break

                                @default
                                    <label class="badge bg-light">Inconnu</label>
                            @endswitch
                        </td>
                        <td>
                            @switch($user->status)
                                @case(0)
                                    <label class="badge bg-danger">Pasif</label>
                                @break

                                @case(1)
                                    <label class="badge bg-success">Aktif</label>
                                @break
                            @endswitch
                        </td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @format_date($user->created_at)
                        </td>
                        <td class="text-center">
                            <a href="#"
                                class="btn btn-sm btn-success">
                                <i class="fas fa-user-edit mr-2"></i>
                                Éditer
                            </a>
                            <button data-id="{{ $user->id }}"
                                data-url="#"
                                class="btn btn-sm btn-danger remove-btn">
                                <i class="fas fa-user-minus mr-2"></i>
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-loading-component>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('script')
    <x-datatable-js-link />
@endsection
