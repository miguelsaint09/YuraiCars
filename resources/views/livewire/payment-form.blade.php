<div class="payment-form">
    <div class="payment-section">
        <h3 class="payment-title">Información de Pago</h3>
        <p class="payment-subtitle">Complete los detalles de su tarjeta para procesar el pago.</p>

        <form wire:submit.prevent="processPayment" autocomplete="off">
            <!-- Información del titular -->
            <div class="form-group">
                <label class="form-label">Nombre del Titular</label>
                <input 
                    type="text"
                    wire:model.defer="cardHolderName"
                    class="form-input"
                    placeholder="Como aparece en la tarjeta"
                    maxlength="100"
                    autocomplete="off"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                />
                @error('cardHolderName') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-grid">
                <!-- Cédula -->
                <div class="form-group" x-data="{
                    visual: '',
                    update(val) {
                        let real = val.replace(/\D/g, '').slice(0, 11);
                        if(real.length > 3 && real.length <= 10) val = real.replace(/(\d{3})(\d+)/, '$1-$2');
                        else if(real.length > 10) val = real.replace(/(\d{3})(\d{7})(\d+)/, '$1-$2-$3');
                        else val = real;
                        this.visual = val;
                        $refs.realInput.value = real;
                        $refs.realInput.dispatchEvent(new Event('input'));
                    }
                }" x-init="update('')">
                    <label class="form-label">Cédula</label>
                    <input type="text" x-model="visual" @input="update($event.target.value)" maxlength="13" class="form-input" placeholder="000-0000000-0" autocomplete="off" />
                    <input type="hidden" x-ref="realInput" wire:model.defer="cedula" />
                    @error('cedula') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Teléfono -->
                <div class="form-group" x-data="{
                    visual: '',
                    update(val) {
                        let real = val.replace(/\D/g, '').slice(0, 10);
                        if(real.length > 3 && real.length <= 6) val = real.replace(/(\d{3})(\d+)/, '$1-$2');
                        else if(real.length > 6) val = real.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
                        else val = real;
                        this.visual = val;
                        $refs.realInput.value = real;
                        $refs.realInput.dispatchEvent(new Event('input'));
                    }
                }" x-init="update('')">
                    <label class="form-label">Teléfono</label>
                    <input type="text" x-model="visual" @input="update($event.target.value)" maxlength="12" class="form-input" placeholder="809-000-0000" autocomplete="off" />
                    <input type="hidden" x-ref="realInput" wire:model.defer="phone" />
                    @error('phone') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input 
                    type="email"
                    wire:model.defer="email" 
                    class="form-input" 
                    placeholder="ejemplo@correo.com"
                    autocomplete="off"
                />
                @error('email') 
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Información de la tarjeta -->
            <div class="form-group" x-data="{
                visual: '',
                update(val) {
                    let real = val.replace(/\D/g, '').slice(0, 16);
                    val = real.replace(/(.{4})/g, '$1 ').trim();
                    this.visual = val;
                    $refs.realInput.value = real;
                    $refs.realInput.dispatchEvent(new Event('input'));
                }
            }" x-init="update('')">
                <label class="form-label">Número de Tarjeta</label>
                <div class="card-input-wrapper">
                    <input type="text" x-model="visual" @input="update($event.target.value)" maxlength="19" class="form-input" placeholder="0000 0000 0000 0000" autocomplete="off" />
                    <input type="hidden" x-ref="realInput" wire:model.defer="cardNumber" />
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
                <!-- Fecha de Vencimiento -->
                <div class="form-group" x-data="{
                    visual: '',
                    update(val) {
                        let real = val.replace(/\D/g, '').slice(0, 4);
                        if(real.length > 2) val = real.replace(/(\d{2})(\d+)/, '$1/$2');
                        else val = real;
                        this.visual = val;
                        $refs.realInput.value = val;
                        $refs.realInput.dispatchEvent(new Event('input'));
                    }
                }" x-init="update('')">
                    <label class="form-label">Fecha de Vencimiento</label>
                    <input type="text" x-model="visual" @input="update($event.target.value)" maxlength="5" class="form-input" placeholder="MM/YY" autocomplete="off" />
                    <input type="hidden" x-ref="realInput" wire:model.defer="expiryDate" />
                    @error('expiryDate') 
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <!-- CVV -->
                <div class="form-group" x-data="{
                    visual: '',
                    update(val) {
                        let real = val.replace(/\D/g, '').slice(0, 4);
                        this.visual = real;
                        $refs.realInput.value = real;
                        $refs.realInput.dispatchEvent(new Event('input'));
                    }
                }" x-init="update('')">
                    <label class="form-label">CVV</label>
                    <input type="text" x-model="visual" @input="update($event.target.value)" maxlength="4" class="form-input" placeholder="123" autocomplete="off" />
                    <input type="hidden" x-ref="realInput" wire:model.defer="cvv" />
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
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
        }

        .card-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .card-type {
            position: absolute;
            right: 1rem;
            display: flex;
            align-items: center;
        }

        .card-logo {
            height: 24px;
            width: auto;
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
            background: linear-gradient(145deg, rgba(99, 102, 241, 0.8) 0%, rgba(79, 70, 229, 0.9) 100%);
            border: 1px solid rgba(99, 102, 241, 0.4);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 8px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }
    </style>
</div> 