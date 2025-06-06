<x-layouts.app title="Acerca de YuraiCars">
@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

    .about-page {
        background: radial-gradient(circle at 25% 40%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 75% 60%, rgba(168, 85, 247, 0.08) 0%, transparent 50%),
                    radial-gradient(circle at 45% 20%, rgba(120, 119, 198, 0.06) 0%, transparent 50%),
                    linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: #ffffff;
        position: relative;
        overflow-x: hidden;
    }

    .about-page::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 35% 30%, rgba(99, 102, 241, 0.12) 0%, transparent 60%),
            radial-gradient(circle at 65% 70%, rgba(168, 85, 247, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 15% 80%, rgba(120, 119, 198, 0.08) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
        animation: atmosphericFlow 30s ease-in-out infinite;
    }

    @keyframes atmosphericFlow {
        0%, 100% { opacity: 0.4; transform: scale(1) rotate(0deg); }
        25% { opacity: 0.7; transform: scale(1.05) rotate(0.25deg); }
        50% { opacity: 0.5; transform: scale(1.1) rotate(-0.25deg); }
        75% { opacity: 0.8; transform: scale(1.05) rotate(0.5deg); }
    }

    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 2rem;
        position: relative;
        z-index: 2;
    }

    .hero-section {
        text-align: center;
        margin-bottom: 8rem;
        padding: 4rem 0;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, 
            rgba(99, 102, 241, 0.15) 0%, 
            rgba(168, 85, 247, 0.1) 40%, 
            transparent 70%);
        filter: blur(100px);
        animation: heroAura 12s ease-in-out infinite;
        z-index: -1;
    }

    @keyframes heroAura {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1); 
            opacity: 0.6; 
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.4); 
            opacity: 0.9; 
        }
    }

    .hero-title {
        font-size: 4.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, 
            #ffffff 0%, 
            #f3f4f6 15%, 
            #ffffff 30%, 
            #e5e7eb 45%, 
            #ffffff 60%, 
            #d1d5db 75%, 
            #ffffff 90%, 
            #f9fafb 100%);
        background-size: 400% 400%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.08em;
        line-height: 1.05;
        opacity: 0;
        animation: titleCinematic 1.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards,
                   titleGradientFlow 10s ease-in-out infinite;
        text-shadow: 0 0 60px rgba(255, 255, 255, 0.2);
    }

    @keyframes titleCinematic {
        0% {
            opacity: 0;
            transform: translateY(100px) scale(0.6) rotateX(15deg);
            filter: blur(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0);
        }
    }

    @keyframes titleGradientFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .hero-subtitle {
        font-size: 1.4rem;
        color: #d1d5db;
        font-weight: 500;
        max-width: 700px;
        margin: 0 auto 4rem;
        line-height: 1.7;
        opacity: 0;
        animation: subtitleEmerge 1.4s ease-out 0.5s forwards;
        position: relative;
        letter-spacing: 0.02em;
    }

    @keyframes subtitleEmerge {
        0% {
            opacity: 0;
            transform: translateY(50px);
            filter: blur(5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
            filter: blur(0);
        }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2.5rem;
        margin: 4rem 0;
        opacity: 0;
        animation: statsReveal 1.2s ease-out 0.8s forwards;
    }

    @keyframes statsReveal {
        0% {
            opacity: 0;
            transform: translateY(60px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.6), 
            rgba(168, 85, 247, 0.4), 
            rgba(120, 119, 198, 0.6), 
            transparent);
        filter: blur(1px);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: conic-gradient(from 0deg, 
            transparent 0deg, 
            rgba(99, 102, 241, 0.04) 90deg, 
            transparent 180deg,
            rgba(168, 85, 247, 0.04) 270deg,
            transparent 360deg);
        animation: statRotate 25s linear infinite;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.6s ease;
    }

    @keyframes statRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .stat-card:hover {
        transform: translateY(-8px) rotateY(2deg);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1),
            0 0 60px rgba(99, 102, 241, 0.2);
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 50%, #ffffff 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        letter-spacing: -0.04em;
        line-height: 1;
        animation: numberPulse 8s ease-in-out infinite;
    }

    @keyframes numberPulse {
        0%, 100% { 
            background-position: 0% 50%; 
            transform: scale(1);
        }
        50% { 
            background-position: 100% 50%; 
            transform: scale(1.02);
        }
    }

    .stat-label {
        font-size: 1rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-weight: 700;
    }

    .section {
        margin: 8rem 0;
        opacity: 0;
        animation: sectionFloat 1s ease-out forwards;
    }

    .section:nth-child(3) { animation-delay: 1s; }
    .section:nth-child(4) { animation-delay: 1.2s; }
    .section:nth-child(5) { animation-delay: 1.4s; }

    @keyframes sectionFloat {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-title {
        font-size: 2.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 70%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 3rem;
        text-align: center;
        letter-spacing: -0.04em;
        line-height: 1.1;
        animation: sectionTitleShift 8s ease-in-out infinite;
        position: relative;
    }

    @keyframes sectionTitleShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.7), 
            rgba(168, 85, 247, 0.5), 
            rgba(120, 119, 198, 0.7), 
            transparent);
        border-radius: 4px;
        filter: blur(1px);
    }

    .section-content {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        padding: 4rem;
        backdrop-filter: blur(25px);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 
            0 15px 50px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .section-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.4), 
            rgba(168, 85, 247, 0.6), 
            rgba(120, 119, 198, 0.4), 
            transparent);
        filter: blur(1px);
    }

    .section-content:hover {
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-5px);
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .section-text {
        font-size: 1.3rem;
        line-height: 1.8;
        color: #e5e7eb;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
        font-weight: 500;
        letter-spacing: 0.01em;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .feature-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        transform-style: preserve-3d;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.1), 
            transparent);
        transition: left 0.8s ease;
        z-index: 1;
    }

    .feature-card:hover::before {
        left: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px) rotateY(3deg) rotateX(3deg);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 25px 70px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1),
            0 0 50px rgba(99, 102, 241, 0.2);
    }

    .feature-icon {
        font-size: 4rem;
        margin-bottom: 2rem;
        opacity: 0.9;
        filter: drop-shadow(0 8px 25px rgba(0, 0, 0, 0.4));
        transition: all 0.4s ease;
        position: relative;
        z-index: 2;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) translateZ(10px);
        filter: drop-shadow(0 12px 35px rgba(0, 0, 0, 0.6));
    }

    .feature-title {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.03em;
        position: relative;
        z-index: 2;
    }

    .feature-description {
        color: #d1d5db;
        line-height: 1.7;
        font-size: 1.05rem;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
        margin-top: 4rem;
    }

    .team-card {
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 12px 45px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .team-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(168, 85, 247, 0.08), 
            transparent);
        transition: left 0.7s ease;
    }

    .team-card:hover::before {
        left: 100%;
    }

    .team-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .team-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(145deg, 
            rgba(99, 102, 241, 0.8) 0%, 
            rgba(168, 85, 247, 0.6) 50%, 
            rgba(120, 119, 198, 0.8) 100%);
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #ffffff;
        border: 3px solid rgba(255, 255, 255, 0.15);
        box-shadow: 
            0 8px 30px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
    }

    .team-card:hover .team-avatar {
        transform: scale(1.1);
        box-shadow: 
            0 12px 40px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 30px rgba(99, 102, 241, 0.4);
    }

    .team-name {
        font-size: 1.4rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        letter-spacing: -0.03em;
    }

    .team-role {
        color: #9ca3af;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
    }

    .cta-section {
        text-align: center;
        padding: 5rem 3rem;
        margin: 8rem 0;
        background: linear-gradient(145deg, 
            rgba(255, 255, 255, 0.08) 0%, 
            rgba(255, 255, 255, 0.04) 50%, 
            rgba(255, 255, 255, 0.02) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 32px;
        backdrop-filter: blur(25px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.15),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(99, 102, 241, 0.8), 
            rgba(168, 85, 247, 0.6), 
            rgba(120, 119, 198, 0.8), 
            transparent);
        filter: blur(1px);
    }

    .cta-section:hover {
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-5px);
        box-shadow: 
            0 30px 100px rgba(0, 0, 0, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            inset 0 -1px 0 rgba(0, 0, 0, 0.1);
    }

    .cta-title {
        font-size: 2.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 30%, #ffffff 70%, #e5e7eb 100%);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1.5rem;
        letter-spacing: -0.04em;
        line-height: 1.1;
        animation: ctaTitleFlow 8s ease-in-out infinite;
    }

    @keyframes ctaTitleFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .cta-text {
        font-size: 1.3rem;
        color: #d1d5db;
        margin-bottom: 3rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.7;
        font-weight: 500;
    }

    .cta-button {
        background: linear-gradient(145deg, 
            rgba(99, 102, 241, 0.9) 0%, 
            rgba(168, 85, 247, 0.8) 50%, 
            rgba(120, 119, 198, 0.9) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem 3.5rem;
        font-weight: 800;
        color: #ffffff;
        text-decoration: none;
        display: inline-block;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 12px 35px rgba(99, 102, 241, 0.5),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .cta-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent);
        transition: left 0.6s ease;
    }

    .cta-button:hover::before {
        left: 100%;
    }

    .cta-button:hover {
        background: linear-gradient(145deg, 
            rgba(99, 102, 241, 1) 0%, 
            rgba(168, 85, 247, 0.9) 50%, 
            rgba(120, 119, 198, 1) 100%);
        border-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-4px) scale(1.05);
        box-shadow: 
            0 20px 50px rgba(99, 102, 241, 0.7),
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 30px rgba(99, 102, 241, 0.5);
        text-decoration: none;
        color: #ffffff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-modern {
            padding: 2rem 1rem;
        }
        
        .hero-title {
            font-size: 3rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
        }
        
        .section-content {
            padding: 3rem;
        }
        
        .stats-grid,
        .features-grid,
        .team-grid {
            grid-template-columns: 1fr;
        }
        
        .cta-section {
            padding: 4rem 2rem;
        }
        
        .section-title {
            font-size: 2.2rem;
        }
        
        .cta-title {
            font-size: 2.2rem;
        }
    }
</style>
@endpush

<div class="about-page">
    <div class="container-modern">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">YuraiCars Premium</h1>
            <p class="hero-subtitle">
                Redefiniendo la experiencia de movilidad premium en República Dominicana desde 2020. 
                Cada vehículo, cada servicio, cada momento diseñado para superar sus expectativas más exigentes.
            </p>
            
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">750+</div>
                    <div class="stat-label">Clientes Premium</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">85+</div>
                    <div class="stat-label">Vehículos Exclusivos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">4</div>
                    <div class="stat-label">Años de Excelencia</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Concierge Premium</div>
                </div>
            </div>
        </div>
    
        <!-- Mission Section -->
        <div class="section">
            <h2 class="section-title">Filosofía de Excelencia</h2>
            <div class="section-content">
                <p class="section-text">
                    YuraiCars trasciende el concepto tradicional de alquiler de vehículos. Somos arquitectos de experiencias 
                    excepcionales, curadores de momentos únicos y guardianes de la excelencia automotriz. Cada interacción 
                    con nuestro servicio está meticulosamente diseñada para reflejar los más altos estándares de calidad, 
                    sofisticación y atención personalizada que nuestros clientes distinguidos merecen.
                </p>
            </div>
            </div>
    
        <!-- Services Section -->
        <div class="section">
            <h2 class="section-title">Servicios de Élite</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title">Colección Automotriz Exclusiva</h3>
                    <p class="feature-description">
                        Flota meticulosamente curada de vehículos premium, cada uno seleccionado por su excepcional 
                        rendimiento, diseño vanguardista y tecnología de última generación.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h3 class="feature-title">Protección Integral Premium</h3>
                    <p class="feature-description">
                        Cobertura comprehensiva que incluye seguro de gama alta, asistencia especializada 
                        y protección completa para una tranquilidad absoluta.
                        </p>
                    </div>
                <div class="feature-card">
                    <div class="feature-icon">🚁</div>
                    <h3 class="feature-title">Servicio de Concierge Personalizado</h3>
                    <p class="feature-description">
                        Entrega y recogida ejecutiva en cualquier ubicación, incluyendo servicios VIP 
                        en aeropuertos, hoteles de lujo y residencias privadas.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💎</div>
                    <h3 class="feature-title">Transparencia Tarifaria Absoluta</h3>
                    <p class="feature-description">
                        Estructura de precios cristalina sin sorpresas, con opciones flexibles 
                        adaptadas a las necesidades más sofisticadas y exigentes.
                        </p>
                    </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Reservación Instantánea Elite</h3>
                    <p class="feature-description">
                        Plataforma digital de vanguardia que permite confirmar su experiencia premium 
                        en segundos con la máxima eficiencia y elegancia.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌟</div>
                    <h3 class="feature-title">Excelencia Operacional 360°</h3>
                    <p class="feature-description">
                        Atención especializada y soporte ejecutivo continuo para garantizar 
                        una experiencia automotriz verdaderamente excepcional.
                        </p>
                    </div>
                </div>
            </div>
    
        <!-- Team Section -->
        <div class="section">
            <h2 class="section-title">Equipo de Especialistas</h2>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">MA</div>
                    <h3 class="team-name">Miguel Andres</h3>
                    <p class="team-role">Director Ejecutivo</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">CS</div>
                    <h3 class="team-name">Concierge Premium</h3>
                    <p class="team-role">Experiencia del Cliente</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">TE</div>
                    <h3 class="team-name">Especialistas Técnicos</h3>
                    <p class="team-role">Excelencia Automotriz</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">LP</div>
                    <h3 class="team-name">Logística Premium</h3>
                    <p class="team-role">Coordinación Ejecutiva</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h2 class="cta-title">Experimente la Diferencia Premium</h2>
            <p class="cta-text">
                Descubra por qué los clientes más exigentes de República Dominicana confían en YuraiCars 
                para sus necesidades de movilidad premium. Reserve ahora y experimente la excelencia automotriz.
            </p>
            <a href="{{ route('vehicles.index') }}" class="cta-button">
                Iniciar Experiencia Premium
            </a>
        </div>
        </div>
    </div>
</x-layouts.app>