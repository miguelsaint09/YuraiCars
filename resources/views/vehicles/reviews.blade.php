<x-layouts.app title="Reseñas de {{ $vehicle->name }}">
    @push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        .vehicles-page {
            background: radial-gradient(circle at 15% 30%, rgba(168, 85, 247, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 85% 70%, rgba(120, 119, 198, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                        linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 25%, #0f0f0f 50%, #1a1a1a 75%, #0a0a0a 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            position: relative;
            overflow-x: hidden;
        }
        .container-modern {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }
        .reviews-container {
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.08) 0%, 
                rgba(255, 255, 255, 0.04) 50%, 
                rgba(255, 255, 255, 0.02) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 3rem;
            backdrop-filter: blur(25px);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 12px 45px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                inset 0 -1px 0 rgba(0, 0, 0, 0.1);
            color: #fff;
            margin-top: 2rem;
        }
        .vehicle-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .vehicle-header img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 18px;
            border: 1.5px solid #a855f7;
            background: #18181b;
        }
        .vehicle-header .vehicle-info {
            flex: 1;
        }
        .vehicle-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #a855f7 50%, #6366f1 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
            line-height: 1.2;
        }
        .vehicle-meta {
            color: #c4b5fd;
            font-size: 1.1rem;
            font-weight: 500;
        }
        .reviews-list {
            margin-bottom: 2.5rem;
        }
        .review-item {
            border-bottom: 1px solid #3f3f46;
            padding-bottom: 1.2rem;
            margin-bottom: 1.2rem;
        }
        .review-author {
            font-weight: 700;
            color: #fff;
        }
        .review-rating {
            color: #fde68a;
            font-size: 1.1rem;
            margin-left: 0.5rem;
        }
        .review-comment {
            color: #d1d5db;
            margin-top: 0.3rem;
        }
        .empty-reviews {
            color: #a1a1aa;
            text-align: center;
            margin: 2rem 0;
        }
        .btn-review {
            display: inline-block;
            background: linear-gradient(145deg, #a855f7 0%, #6366f1 100%);
            color: #fff;
            font-weight: 700;
            padding: 0.9rem 2.2rem;
            border-radius: 14px;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(168, 85, 247, 0.2);
            border: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        .btn-review:hover {
            background: linear-gradient(145deg, #9333ea 0%, #4f46e5 100%);
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.3);
        }
        .review-form {
            background: rgba(39, 39, 42, 0.95);
            border-radius: 18px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 24px rgba(120, 119, 198, 0.08);
        }
        .review-form label {
            color: #c4b5fd;
            font-weight: 600;
        }
        .review-form .form-input, .review-form textarea {
            width: 100%;
            padding: 0.8rem 1.2rem;
            background: #18181b;
            border: 1px solid #a855f7;
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            margin-top: 0.5rem;
            margin-bottom: 1.2rem;
            transition: border 0.2s;
        }
        .review-form .form-input:focus, .review-form textarea:focus {
            border-color: #6366f1;
            outline: none;
        }
        .review-form button {
            background: linear-gradient(145deg, #a855f7 0%, #6366f1 100%);
            color: #fff;
            font-weight: 700;
            padding: 0.7rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            border: none;
            transition: all 0.3s;
            cursor: pointer;
        }
        .review-form button:hover {
            background: linear-gradient(145deg, #9333ea 0%, #4f46e5 100%);
            transform: translateY(-1px) scale(1.02);
        }
        .page-title {
            font-size: 4.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #a855f7 50%, #6366f1 100%);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            letter-spacing: -0.06em;
            line-height: 1.05;
            text-shadow: 0 0 50px rgba(168, 85, 247, 0.15);
            animation: titleGradient 8s ease-in-out infinite;
        }
        @keyframes titleGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .page-subtitle {
            font-size: 2rem;
            color: #c4b5fd;
            font-weight: 600;
            max-width: 900px;
            margin: 0 auto 2.5rem auto;
            line-height: 1.5;
            text-align: center;
            opacity: 0.95;
            letter-spacing: -0.01em;
            text-shadow: 0 2px 24px rgba(120, 119, 198, 0.12);
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #fde68a !important;
            transition: color 0.2s;
        }
        .star-rating label {
            color: #a1a1aa;
            transition: color 0.2s;
        }
    </style>
    @endpush

    <div class="vehicles-page text-white">
        <div class="container-modern">
            <div class="page-header">
                <a href="{{ url()->previous() }}" class="text-indigo-400 hover:underline mb-6 inline-block">&larr; Volver</a>
                <h1 class="page-title">Reseñas de {{ $vehicle->name }} {{ $vehicle->year }}</h1>
                <p class="page-subtitle"></p>
            </div>
            <div class="reviews-container">
                <div class="vehicle-header">
                    @if($vehicle->image_url && is_array($vehicle->image_url) && !empty($vehicle->image_url))
                        <img src="{{ Storage::url($vehicle->image_url[0]) }}" alt="{{ $vehicle->name }}" />
                    @endif
                    <div class="vehicle-info">
                        <div class="vehicle-title">{{ $vehicle->name }} {{ $vehicle->year }}</div>
                        <div class="vehicle-meta">{{ $vehicle->category }} | {{ ucfirst($vehicle->transmission) }}</div>
                    </div>
                </div>
                <h2 class="text-2xl font-bold mb-6 text-indigo-400">Reseñas de Clientes</h2>
                <div class="reviews-list">
                    @forelse($vehicle->reviews as $review)
                        <div class="review-item">
                            <div>
                                <span class="review-author">{{ $review->user->profile->first_name ?? 'Cliente' }}</span>
                                <span class="review-rating">
                                    @for($i = 0; $i < $review->rating; $i++)★@endfor
                                </span>
                            </div>
                            <div class="review-comment">{{ $review->comment }}</div>
                        </div>
                    @empty
                        <div class="empty-reviews">Este vehículo aún no tiene reseñas.</div>
                    @endforelse
                </div>
                @auth
                <form id="review-form" action="{{ route('vehicles.review', $vehicle) }}" method="POST" class="review-form mt-4">
                    @csrf
                    <div>
                        <label>Calificación</label>
                        <div class="star-rating flex flex-row-reverse justify-end text-3xl gap-2 mt-2 mb-4">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required />
                                <label for="star{{ $i }}" class="cursor-pointer select-none text-gray-400 hover:text-yellow-400 transition-colors duration-200">
                                    ★
                                </label>
                            @endfor
                        </div>
                    </div>
                    <div>
                        <label>Comentario</label>
                        <textarea name="comment" rows="3" class="form-input" required></textarea>
                    </div>
                    <button type="submit">Enviar Reseña</button>
                </form>
                @else
                <div class="empty-reviews mt-2">
                    <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Inicia sesión</a> para dejar una reseña.
                </div>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.app> 