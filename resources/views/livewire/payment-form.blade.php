@push('scripts')
<script>
document.addEventListener('livewire:initialized', function () {
    console.log('Payment form initialized');

    // Función helper para prevenir caracteres no válidos
    function preventInvalidChars(e, pattern) {
        if (!pattern.test(e.key) && 
            e.key !== 'Backspace' && 
            e.key !== 'Delete' && 
            e.key !== 'ArrowLeft' && 
            e.key !== 'ArrowRight' && 
            e.key !== 'Tab' && 
            !e.ctrlKey && 
            !e.metaKey) {
            e.preventDefault();
            console.log('Prevented invalid character:', e.key);
        }
    }

    // Formateo de tarjeta de crédito
    const cardInput = document.querySelector('input[wire\\:model\\.live="cardNumber"]');
    console.log('Card input found:', cardInput);
    if (cardInput) {
        let previousLength = 0;
        
        // Prevenir caracteres no numéricos
        cardInput.addEventListener('keydown', function(e) {
            console.log('Card keydown event:', e.key);
            preventInvalidChars(e, /^[0-9\s]$/);
        });

        cardInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = '';
            
            // Eliminar todo excepto números
            value = value.replace(/\D/g, '');
            
            // Formatear con espacios cada 4 dígitos
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                    if (cursorPosition > i) {
                        cursorPosition++;
                    }
                }
                formattedValue += value[i];
            }
            
            // Actualizar el valor
            e.target.value = formattedValue;
            cardInput._x_model.set(formattedValue);
            
            // Mantener el cursor en la posición correcta
            e.target.setSelectionRange(cursorPosition, cursorPosition);
            previousLength = formattedValue.length;
        });

        // Prevenir que se borren los espacios al borrar
        cardInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.value.slice(-1) === ' ') {
                e.target.value = e.target.value.slice(0, -2);
                cardInput._x_model.set(e.target.value);
                e.preventDefault();
            }
        });
    }

    // Formateo de fecha de vencimiento
    const expiryInput = document.querySelector('input[wire\\:model\\.live="expiryDate"]');
    console.log('Expiry input found:', expiryInput);
    if (expiryInput) {
        let previousLength = 0;

        // Prevenir caracteres no numéricos y /
        expiryInput.addEventListener('keydown', function(e) {
            preventInvalidChars(e, /^[0-9/]$/);
        });
        
        expiryInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 2 && previousLength < e.target.value.length) {
                if (!e.target.value.includes('/')) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                    cursorPosition++;
                }
            }
            
            // Limitar a MM/YY
            value = value.substring(0, 4);
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            
            e.target.value = value;
            expiryInput._x_model.set(value);
            e.target.setSelectionRange(cursorPosition, cursorPosition);
            previousLength = value.length;
        });
    }

    // Formateo de CVV
    const cvvInput = document.querySelector('input[wire\\:model\\.live="cvv"]');
    console.log('CVV input found:', cvvInput);
    if (cvvInput) {
        // Prevenir caracteres no numéricos
        cvvInput.addEventListener('keydown', function(e) {
            preventInvalidChars(e, /^[0-9]$/);
        });

        cvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 4); // Limitar a 4 dígitos
            e.target.value = value;
            cvvInput._x_model.set(value);
        });
    }

    // Formateo de cédula
    const cedulaInput = document.querySelector('input[wire\\:model\\.live="cedula"]');
    console.log('Cedula input found:', cedulaInput);
    if (cedulaInput) {
        let previousLength = 0;

        // Prevenir caracteres no numéricos y -
        cedulaInput.addEventListener('keydown', function(e) {
            preventInvalidChars(e, /^[0-9-]$/);
        });

        cedulaInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            // Formatear como XXX-XXXXXXX-X
            for (let i = 0; i < value.length; i++) {
                if (i === 3 || i === 10) {
                    formattedValue += '-';
                    if (cursorPosition > i) {
                        cursorPosition++;
                    }
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
            cedulaInput._x_model.set(formattedValue);
            e.target.setSelectionRange(cursorPosition, cursorPosition);
            previousLength = formattedValue.length;
        });

        // Prevenir que se borren los guiones al borrar
        cedulaInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.value.slice(-1) === '-') {
                e.target.value = e.target.value.slice(0, -2);
                cedulaInput._x_model.set(e.target.value);
                e.preventDefault();
            }
        });
    }

    // Formateo de teléfono
    const phoneInput = document.querySelector('input[wire\\:model\\.live="phone"]');
    console.log('Phone input found:', phoneInput);
    if (phoneInput) {
        let previousLength = 0;

        // Prevenir caracteres no numéricos y -
        phoneInput.addEventListener('keydown', function(e) {
            preventInvalidChars(e, /^[0-9-]$/);
        });

        phoneInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            // Formatear como XXX-XXX-XXXX
            for (let i = 0; i < value.length; i++) {
                if ((i === 3 || i === 6) && i !== value.length) {
                    formattedValue += '-';
                    if (cursorPosition > i) {
                        cursorPosition++;
                    }
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
            phoneInput._x_model.set(formattedValue);
            e.target.setSelectionRange(cursorPosition, cursorPosition);
            previousLength = formattedValue.length;
        });

        // Prevenir que se borren los guiones al borrar
        phoneInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.value.slice(-1) === '-') {
                e.target.value = e.target.value.slice(0, -2);
                phoneInput._x_model.set(e.target.value);
                e.preventDefault();
            }
        });
    }

    // Formateo de nombre del titular
    const nameInput = document.querySelector('input[wire\\:model\\.live="cardHolderName"]');
    console.log('Name input found:', nameInput);
    if (nameInput) {
        // Prevenir caracteres no alfabéticos (permitir letras, espacios y caracteres especiales para nombres)
        nameInput.addEventListener('keydown', function(e) {
            preventInvalidChars(e, /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/);
        });

        nameInput.addEventListener('input', function(e) {
            let cursorPosition = e.target.selectionStart;
            let value = e.target.value.replace(/[0-9]/g, '').toUpperCase();
            e.target.value = value;
            nameInput._x_model.set(value);
            e.target.setSelectionRange(cursorPosition, cursorPosition);
        });
    }
});
</script>
@endpush

<!-- Mensaje de error general -->
@if($errorMessage)
    <div class="error-message">
        {{ $errorMessage }}
    </div>
@endif

<div class="payment-form">
    <div class="payment-section">
        <h3 class="payment-title">Información de Pago</h3>
        <p class="payment-subtitle">Complete los detalles de su tarjeta para procesar el pago.</p>

        <form wire:submit.prevent="processPayment">
            <!-- Información del titular -->
            <div class="form-group">
                <label class="form-label">Nombre del Titular</label>
                <input 
                    type="text"
                    wire:model.live="cardHolderName" 
                    class="form-input @error('cardHolderName') error @enderror" 
                    placeholder="COMO APARECE EN LA TARJETA"
                    maxlength="50"
                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                    oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ\s]/g, '').toUpperCase();"
                />
                @error('cardHolderName') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Cédula</label>
                    <input 
                        type="text"
                        wire:model.live="cedula" 
                        class="form-input @error('cedula') error @enderror" 
                        placeholder="000-0000000-0"
                        maxlength="13"
                        oninput="
                            let value = this.value.replace(/\D/g, '');
                            if (value.length > 0) {
                                if (value.length > 3) value = value.slice(0,3) + '-' + value.slice(3);
                                if (value.length > 11) value = value.slice(0,11) + '-' + value.slice(11);
                            }
                            this.value = value;
                        "
                    />
                    @error('cedula') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input 
                        type="tel"
                        wire:model.live="phone" 
                        class="form-input @error('phone') error @enderror" 
                        placeholder="000-000-0000"
                        maxlength="12"
                        oninput="
                            let value = this.value.replace(/\D/g, '');
                            if (value.length > 0) {
                                if (value.length > 3) value = value.slice(0,3) + '-' + value.slice(3);
                                if (value.length > 7) value = value.slice(0,7) + '-' + value.slice(7);
                            }
                            this.value = value;
                        "
                    />
                    @error('phone') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input 
                    type="email"
                    wire:model.live="email" 
                    class="form-input @error('email') error @enderror" 
                    placeholder="ejemplo@correo.com"
                />
                @error('email') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Información de la tarjeta -->
            <div class="form-group">
                <label class="form-label">Número de Tarjeta</label>
                <div class="card-input-wrapper">
                    <input 
                        type="text"
                        wire:model.live="cardNumber" 
                        class="form-input @error('cardNumber') error @enderror" 
                        placeholder="0000 0000 0000 0000"
                        maxlength="19"
                        oninput="
                            let value = this.value.replace(/\D/g, '');
                            if (value.length > 0) {
                                value = value.match(/.{1,4}/g).join(' ');
                            }
                            this.value = value;
                        "
                    />
                    @if($cardType)
                        <div class="card-type">
                            <img src="{{ asset('images/cards/' . $cardType . '.svg') }}" alt="{{ $cardType }}" class="card-logo"/>
                        </div>
                    @endif
                </div>
                @error('cardNumber') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Fecha de Vencimiento</label>
                    <input 
                        type="text"
                        wire:model.live="expiryDate" 
                        class="form-input @error('expiryDate') error @enderror" 
                        placeholder="MM/YY"
                        maxlength="5"
                        oninput="
                            let value = this.value.replace(/\D/g, '');
                            if (value.length > 2) {
                                value = value.slice(0,2) + '/' + value.slice(2,4);
                            }
                            this.value = value;
                        "
                    />
                    @error('expiryDate') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">CVV</label>
                    <input 
                        type="text"
                        wire:model.live="cvv" 
                        class="form-input @error('cvv') error @enderror" 
                        placeholder="123"
                        maxlength="4"
                        oninput="this.value = this.value.replace(/\D/g, '');"
                    />
                    @error('cvv') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>Total a Pagar:</span>
                    <span class="total-amount">${{ number_format($amount, 2) }} DOP</span>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Procesar Pago</span>
                    <span wire:loading>Procesando...</span>
                </button>
            </div>
        </form>
    </div>

    <style>
        .payment-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .payment-section {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.02) 0%, rgba(255, 255, 255, 0.01) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            margin-bottom: 3rem;
        }

        .payment-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .payment-subtitle {
            color: #94a3b8;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-label {
            display: block;
            color: #e2e8f0;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Courier New', monospace;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
        }

        .form-input.error {
            border-color: rgba(239, 68, 68, 0.5);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .card-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .card-type {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .card-logo {
            width: 40px;
            height: auto;
        }

        .total-section {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 800;
            color: #6366f1;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(145deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #4f46e5 0%, #4338ca 100%);
            transform: translateY(-1px);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</div> 