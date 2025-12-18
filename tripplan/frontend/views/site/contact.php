<?php

/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = 'Contactos e Localização | TripPlan';


?>

<div class="site-contact">
    <div class="contact-wrapper">

        <div class="visual-side">
            <div class="status-badge">
                <span class="status-dot"></span> Disponíveis Online
            </div>
            <div class="visual-content">
                <h3>Visite-nos.</h3>
                <p>Gostamos de conhecer os viajantes pessoalmente. O café é por nossa conta.</p>
            </div>
        </div>

        <div class="info-side">
            <div class="info-header">
                <h1>Fale Connosco</h1>
                <p>Estamos em Leiria, prontos para planear a sua viagem.</p>
            </div>

            <div class="contact-grid">

                <div class="contact-item">
                    <div class="icon-box">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><path d="M22 6l-10 7L2 6"></path></svg>
                    </div>
                    <div class="details">
                        <h4>Email</h4>
                        <a href="mailto:ola@tripplan.pt">suporte@tripplan.pt</a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    </div>
                    <div class="details">
                        <h4>Telefone</h4>
                        <a href="tel:+351912345678">+351 912 345 678</a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <div class="details">
                        <h4>Morada</h4>
                        <span>Leiria, Portugal</span>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="icon-box">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="details">
                        <h4>Horário</h4>
                        <div class="hours-list">
                            <span>Seg - Sex: 09h - 18h</span>
                            <span style="color:#999; font-size:0.8rem;">Sáb - Dom: Fechado</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49354.89675276536!2d-8.847587768225887!3d39.74366696472481!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd220e5ad762dba7%3A0x7d25fa383187b50!2sLeiria!5e0!3m2!1spt-PT!2spt!4v1703000000000!5m2!1spt-PT!2spt"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </div>
</div>