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
                    class="form-input" 
                    placeholder="Como aparece en la tarjeta"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                    inputmode="text"
                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                />
                @error('cardHolderName') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Información de la tarjeta -->
            <div class="form-group">
                <label class="form-label">Número de Tarjeta</label>
                <input 
                    id="cardNumberInput"
                    type="text"
                    wire:model.live="cardNumber" 
                    class="form-input" 
                    placeholder="0000 0000 0000 0000"
                    maxlength="19"
                    inputmode="numeric"
                    pattern="[0-9 ]*"
                    autocomplete="cc-number"
                />
                @error('cardNumber') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Fecha de Vencimiento</label>
                    <input 
                        id="expiryDateInput"
                        type="text"
                        wire:model.live="expiryDate" 
                        class="form-input" 
                        placeholder="MM/YY"
                        maxlength="5"
                        inputmode="numeric"
                        pattern="[0-9/]*"
                        autocomplete="cc-exp"
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
                        class="form-input" 
                        placeholder="123"
                        maxlength="4"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        autocomplete="cc-csc"
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
                <button type="submit" class="btn btn-primary">
                    Procesar Pago
                </button>
            </div>
        </form>
    </div>

    <script>
        // Formatear número de tarjeta con espacios automáticos
        document.addEventListener('DOMContentLoaded', function() {
            const cardInput = document.getElementById('cardNumberInput');
            if(cardInput) {
                cardInput.addEventListener('input', function(e) {
                    let value = cardInput.value.replace(/\D/g, '').substring(0,16);
                    let formatted = value.replace(/(.{4})/g, '$1 ').trim();
                    cardInput.value = formatted;
                });
            }
            // Formatear fecha de vencimiento MM/YY
            const expiryInput = document.getElementById('expiryDateInput');
            if(expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = expiryInput.value.replace(/[^0-9]/g, '').substring(0,4);
                    if(value.length > 2) {
                        value = value.substring(0,2) + '/' + value.substring(2);
                    }
                    expiryInput.value = value;
                });
            }
        });
    </script>

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
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
        }

        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .total-section {
            margin: 2rem 0;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
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
            color: #6366f1;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
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
            background: #6366f1;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #4f46e5;
        }
    </style>
</div> 