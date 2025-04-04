<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.svg') }}" alt="Aquafit" class="footer-logo-img">
                    <span class="footer-logo-text">Aquafit</span>
                </div>
                <p class="footer-description">Plateforme de gestion d'entraînements de natation pour coaches et athlètes.</p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="footer-links-container">
                <div class="footer-col">
                    <h3 class="footer-title">Navigation</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}" class="footer-link">Accueil</a></li>
                        @auth
                            <li><a href="{{ route('exercise.list') }}" class="footer-link">Exercices</a></li>
                            <li><a href="{{ route('program.list') }}" class="footer-link">Programmes</a></li>
                            
                            @if(Auth::user()->isCoach())
                                <li><a href="{{ route('program.athletes') }}" class="footer-link">Mes Athlètes</a></li>
                                <li><a href="{{ route('program.coach') }}" class="footer-link">Mes Programmes</a></li>
                            @endif
                            @if(Auth::user()->isAthlete())
                                <li><a href="{{ route('program.athlete') }}" class="footer-link">Mes Entraînements</a></li>
                            @endif
                            <li><a href="{{ route('profile.edit') }}" class="footer-link">Mon Profil</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="footer-link">Connexion</a></li>
                            <li><a href="{{ route('register') }}" class="footer-link">Inscription</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3 class="footer-title">Contact</h3>
                    <ul class="footer-contact">
                        <li class="contact-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 2H2v20h20V2zM9 20H4v-7h5v7zm11 0h-9v-7h9v7zm0-9H4V4h16v7z"></path>
                            </svg>
                            <span>contact@aquafit.com</span>
                        </li>
                        <li class="contact-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span>+33 1 23 45 67 89</span>
                        </li>
                        <li class="contact-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>123 Avenue des Sports, 75001 Paris</span>
                        </li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3 class="footer-title">Newsletter</h3>
                    <p class="newsletter-text">Inscrivez-vous pour recevoir nos actualités</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Votre email" required>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                &copy; {{ date('Y') }} Aquafit. Tous droits réservés.
            </div>
            <div class="footer-legal">
                <a href="#" class="legal-link">Politique de confidentialité</a>
                <a href="#" class="legal-link">Conditions d'utilisation</a>
                <a href="#" class="legal-link">Mentions légales</a>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: var(--blue-dark);
    color: var(--white);
    padding: var(--spacing-xl) 0 var(--spacing-lg);
    margin-top: auto;
    position: relative;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, var(--blue-primary), var(--blue-medium), var(--blue-light));
}

.footer-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: var(--spacing-xl);
    padding-bottom: var(--spacing-xl);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-brand {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.footer-logo {
    display: flex;
    align-items: center;
}

.footer-logo-img {
    height: 40px;
    filter: brightness(0) invert(1);
}

.footer-logo-text {
    font-family: var(--font-family-heading);
    font-weight: var(--font-weight-bold);
    font-size: var(--font-size-xl);
    color: var(--white);
    margin-left: var(--spacing-sm);
}

.footer-description {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: var(--spacing-md);
    line-height: var(--line-height-normal);
}

.footer-social {
    display: flex;
    gap: var(--spacing-md);
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: var(--white);
    transition: all var(--transition-normal) var(--transition-ease);
}

.social-link:hover {
    background-color: var(--blue-primary);
    color: var(--white);
    transform: translateY(-3px);
}

.footer-links-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-xl);
}

.footer-title {
    color: var(--white);
    font-size: var(--font-size-md);
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--spacing-lg);
    position: relative;
    padding-bottom: var(--spacing-sm);
}

.footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 2px;
    background-color: var(--blue-light);
}

.footer-links,
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: var(--spacing-sm);
}

.footer-link {
    color: rgba(255, 255, 255, 0.8);
    transition: all var(--transition-normal) var(--transition-ease);
    display: inline-block;
    position: relative;
}

.footer-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 1px;
    bottom: -2px;
    left: 0;
    background-color: var(--blue-light);
    transition: width var(--transition-normal) var(--transition-ease);
}

.footer-link:hover {
    color: var(--white);
    transform: translateX(5px);
}

.footer-link:hover::after {
    width: 100%;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    color: rgba(255, 255, 255, 0.8);
}

.contact-item svg {
    flex-shrink: 0;
    color: var(--blue-light);
}

.newsletter-text {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: var(--spacing-md);
}

.newsletter-form .input-group {
    display: flex;
}

.newsletter-form .form-control {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--white);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    height: 44px;
}

.newsletter-form .form-control:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: var(--blue-light);
    box-shadow: none;
}

.newsletter-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.newsletter-form .btn {
    padding: 0 var(--spacing-md);
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    height: 44px;
    min-height: auto;
}

.footer-bottom {
    padding-top: var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: var(--spacing-md);
}

.copyright {
    color: rgba(255, 255, 255, 0.6);
    font-size: var(--font-size-sm);
}

.footer-legal {
    display: flex;
    gap: var(--spacing-lg);
}

.legal-link {
    color: rgba(255, 255, 255, 0.6);
    font-size: var(--font-size-sm);
    transition: color var(--transition-normal) var(--transition-ease);
}

.legal-link:hover {
    color: var(--white);
}

@media (max-width: 992px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: var(--spacing-xl);
    }
    
    .footer-links-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .footer-links-container {
        grid-template-columns: 1fr;
    }
    
    .footer-bottom {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .footer-legal {
        flex-direction: column;
        gap: var(--spacing-sm);
        align-items: center;
    }
}
</style>