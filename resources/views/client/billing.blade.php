@extends('layouts.app')
@section('title', 'Facturation — Harfa.ma')
@section('content')
<div class="portal-layout">
  @include('partials.sidebar-client')
  <div class="portal-content">
    <div class="portal-header">
      <div>
        <h1 class="portal-title">Facturation</h1>
        <p class="portal-subtitle">Harfa.ma est 100% gratuit pour les clients</p>
      </div>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-md-6">
        <div style="background:linear-gradient(135deg,#064e3b,#059669);border-radius:20px;padding:40px;text-align:center;color:white">
          <div style="font-size:56px;margin-bottom:16px">🎉</div>
          <h3 style="color:white;font-weight:800;margin-bottom:12px">Harfa.ma est gratuit !</h3>
          <p style="color:rgba(255,255,255,.8);font-size:16px;line-height:1.7;margin-bottom:24px">
            En tant que client, vous bénéficiez de toutes les fonctionnalités de la plateforme sans frais :
            recherche, réservations, messagerie et avis sont tous gratuits.
          </p>
          <div class="d-flex flex-column gap-2 text-start" style="background:rgba(255,255,255,.1);border-radius:12px;padding:20px">
            @foreach(['Rechercher des artisans','Voir les profils et avis','Réservations illimitées','Messagerie directe','Publier des offres d\'emploi'] as $f)
              <div class="d-flex align-items-center gap-2" style="font-size:14px">
                <i class="bi bi-check-circle-fill" style="color:#6ee7b7;flex-shrink:0"></i>
                {{ $f }}
              </div>
            @endforeach
          </div>
          <a href="{{ route('craftsmen.index') }}" class="btn-harfa mt-4 justify-content-center"
             style="background:white;color:#059669">
            <i class="bi bi-search"></i> Trouver un artisan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
