@extends('layouts.app')
@section('title', 'Tarifs — Harfa.ma')
@section('content')
<div class="container py-4">

  <div class="text-center mb-5" data-aos="fade-down">
    <span style="background:#d1fae5;color:#059669;padding:5px 18px;border-radius:999px;font-size:13px;font-weight:700">Tarification simple</span>
    <h1 style="font-size:clamp(28px,5vw,44px);font-weight:800;color:#0f172a;margin:20px 0 16px">
      Des prix transparents pour tous
    </h1>
    <p style="font-size:17px;color:#64748b;max-width:560px;margin:0 auto">
      Harfa.ma est gratuit pour les clients. Les artisans utilisent des points pour postuler aux offres.
    </p>
  </div>

  {{-- Client plans --}}
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title"><i class="bi bi-person-circle me-2" style="color:#059669"></i>Pour les clients</h2>
      <p class="section-subtitle">Trouvez un artisan gratuitement, sans abonnement</p>
    </div>
  </div>

  <div class="row g-4 mb-5 justify-content-center">
    <div class="col-md-5" data-aos="fade-up">
      <div class="pricing-card popular">
        <div style="width:64px;height:64px;background:#d1fae5;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;color:#059669;margin:0 auto 16px">
          <i class="bi bi-person-circle"></i>
        </div>
        <h4 style="font-weight:800;color:#0f172a;margin-bottom:8px">Client</h4>
        <div class="price-amount">
          <span class="price-currency">0</span>
        </div>
        <div class="price-period">Gratuit pour toujours</div>
        <ul class="price-features">
          <li><i class="bi bi-check-circle-fill"></i> Rechercher des artisans</li>
          <li><i class="bi bi-check-circle-fill"></i> Voir les profils et avis</li>
          <li><i class="bi bi-check-circle-fill"></i> Réservations illimitées</li>
          <li><i class="bi bi-check-circle-fill"></i> Messagerie directe</li>
          <li><i class="bi bi-check-circle-fill"></i> Publier des offres d'emploi</li>
          <li><i class="bi bi-check-circle-fill"></i> Évaluer les artisans</li>
        </ul>
        <a href="{{ route('register') }}" class="btn-harfa w-100 justify-content-center">
          <i class="bi bi-person-plus"></i> S'inscrire gratuitement
        </a>
      </div>
    </div>
  </div>

  {{-- Artisan plans --}}
  <div class="section-header mb-4">
    <div>
      <h2 class="section-title"><i class="bi bi-tools me-2" style="color:#059669"></i>Pour les artisans</h2>
      <p class="section-subtitle">Achetez des points pour postuler aux offres · 5 points par candidature</p>
    </div>
  </div>

  <div class="row g-4 mb-5 justify-content-center" data-aos="fade-up">
    @foreach([
      ['Starter','50 pts','99 MAD','#3b82f6','#dbeafe','bi-lightning',false,[
        '10 candidatures possibles','Valable à vie','Accès aux offres en temps réel','Support standard',
      ]],
      ['Pro','120 pts','199 MAD','#059669','#d1fae5','bi-star-fill',true,[
        '24 candidatures possibles','Valable à vie','Badge artisan Pro','Priorité dans les résultats','Support prioritaire',
      ]],
      ['Élite','300 pts','399 MAD','#7c3aed','#ede9fe','bi-gem',false,[
        '60 candidatures possibles','Valable à vie','Badge artisan Élite','Top des résultats de recherche','Support dédié 24/7',
      ]],
    ] as $plan)
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
        <div class="pricing-card {{ $plan[6] ? 'popular' : '' }}">
          <div style="width:64px;height:64px;background:{{ $plan[4] }};border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;color:{{ $plan[3] }};margin:0 auto 16px">
            <i class="bi {{ $plan[5] }}"></i>
          </div>
          <h4 style="font-weight:800;color:#0f172a;margin-bottom:8px">Pack {{ $plan[0] }}</h4>
          <div class="price-amount" style="color:{{ $plan[3] }}">
            <span style="font-size:20px;font-weight:700;vertical-align:super;color:{{ $plan[3] }}">{{ $plan[1] }}</span>
          </div>
          <div style="font-size:24px;font-weight:800;color:#0f172a;margin:8px 0 4px">{{ $plan[2] }}</div>
          <div class="price-period">Paiement unique</div>
          <ul class="price-features">
            @foreach($plan[7] as $feat)
              <li><i class="bi bi-check-circle-fill"></i> {{ $feat }}</li>
            @endforeach
          </ul>
          <a href="{{ route('register', ['role'=>'craftsman']) }}"
             class="btn-harfa w-100 justify-content-center"
             style="background:linear-gradient(135deg,{{ $plan[3] }},{{ $plan[3] }}cc)">
            <i class="bi bi-cart-plus"></i> Choisir ce pack
          </a>
        </div>
      </div>
    @endforeach
  </div>

  {{-- FAQ --}}
  <section data-aos="fade-up">
    <div class="text-center mb-4">
      <h2 class="section-title">Questions fréquentes</h2>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div id="faqAccordion">
          @foreach([
            ['Est-ce vraiment gratuit pour les clients ?','Oui, complètement gratuit. Vous pouvez rechercher, contacter et réserver des artisans sans jamais payer quoi que ce soit sur Harfa.ma.'],
            ['Combien coûte chaque candidature ?','Chaque candidature à une offre d\'emploi coûte 5 points. Un pack Starter (50 pts) permet donc 10 candidatures.'],
            ['Les points expirent-ils ?','Non, vos points sont valables à vie. Ils ne sont débités que lorsque vous postulez à une offre.'],
            ['Comment sont vérifiés les artisans ?','Notre équipe vérifie l\'identité, les compétences et les références de chaque artisan avant validation de son profil.'],
            ['Puis-je être remboursé ?','Si votre candidature ne mène à aucun résultat après 30 jours, nous vous remboursons les points utilisés.'],
          ] as $faq)
            <div class="accordion-item mb-3" style="border:1.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq{{ $loop->index }}"
                        style="background:white;font-weight:600;font-size:15px;color:#0f172a;border:none;border-radius:12px;padding:18px 20px">
                  {{ $faq[0] }}
                </button>
              </h2>
              <div id="faq{{ $loop->index }}" class="accordion-collapse collapse">
                <div class="accordion-body" style="color:#475569;font-size:14px;line-height:1.7;padding:0 20px 18px">
                  {{ $faq[1] }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
