<template>
    <div v-if="sessionObject !== null" class="payment-container-modal" id="paymentModal">
        <div class="payment-container">
            <div class="payment-header">
                <button class="close-btn" @click="closeModal" aria-label="Close modal">×</button>
                <h1>Choose Payment Method</h1>
                <p>Select your preferred payment method and amount</p>
            </div>

            <form @submit.prevent="handleSubmit">
                <!-- Amount Selection -->
                <div class="amount-section">
                    <h3 class="section-title">Payment Amount</h3>
                    <div class="amount-options">
                        <div v-for="(amount, index) in sessionObject.PaymentAmounts" class="amount-option" :key="`amount-${index}`">
                            <input type="radio" :id="`amount-${amount.PaymentAmount}`" name="amount" :value="amount.PaymentAmount" v-model="selectedAmount">
                            <label :for="`amount-${amount.PaymentAmount}`">${{ amount.PaymentAmount }}</label>
                        </div>
                        <div class="amount-option">
                            <input id="custom-amount" type="radio" name="amount" value="custom" v-model="selectedAmount">
                            <label for="custom-amount">Custom</label>
                        </div>
                    </div>
                    <div v-if="selectedAmount === 'custom'" class="custom-amount">
                        <input
                            type="number"
                            placeholder="Enter custom amount"
                            :min="sessionObject.Limits.MinAmount"
                            :max="sessionObject.Limits.MaxAmount"
                            step="0.01"
                            v-model="customAmount"
                        >
                    </div>
                </div>

                <!-- Saved Payment Methods -->
                <div v-if="sessionObject.PaymentMethods.length > 0" class="saved-methods">
                    <h3 class="section-title">Saved Payment Methods</h3>

                    <div class="payment-methods-grid">
                        <div v-for="(method, index) in sessionObject.PaymentMethods" :key="`payment-method-${index}`" class="payment-method-container">
                            <div class="payment-method">
                                <input type="radio" :id="`payment-method-${index}`" name="payment-method" :value="`saved-${index}`" v-model="selectedPaymentMethod">
                                <label :for="`payment-method-${index}`">
                                    <div class="payment-icon card-icon">💳</div>
                                    <div class="payment-info">
                                        <div class="payment-title">{{ method.Network }} {{ method.DisplayName }}</div>
                                        <div class="payment-details">Expires {{ method.ExpirationDate }} {{ method.Type }}</div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add New Payment Methods -->
                <div v-if="sessionObject.PaymentMethodSettings.length > 0" class="payment-methods">
                    <h3 class="section-title">Add New Payment Method</h3>

                    <div class="payment-methods-grid">
                        <!-- Credit/Debit Card -->
                        <div v-for="(method, index) in sessionObject.PaymentMethodSettings" :key="`new-methods-${index}`" class="payment-method-container">
                            <div class="payment-method">
                                <input type="radio" :id="`new-methods-${index}`" name="payment-method" :value="`new-${index}`" v-model="selectedPaymentMethod">
                                <label :for="`new-methods-${index}`">
                                    <div class="payment-icon card-icon">💳</div>
                                    <div class="payment-info">
                                        <div class="payment-title">{{ method.Type }}</div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Forms (span full width) -->
                        <div class="payment-form" id="payment-form-fields" style="grid-column: 1 / -1;"></div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="summary" v-if="showSummary">
                    <div class="summary-item">
                        <span>Amount:</span>
                        <span>${{ finalAmount.toFixed(2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Payment Method:</span>
                        <span>{{ paymentMethodName }}</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total:</span>
                        <span>{{ finalAmount.toFixed(2) }}</span>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="cancel-btn" @click="closeModal">
                        Cancel
                    </button>
                    <button type="submit" class="proceed-btn" :disabled="!canProceed">
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import * as GIDX from 'gidx-js';

export default {
    name: 'PaymentMethodModal',
    props: {
        toggleShowModal: {
            type: Function,
            required: true
        },
        sessionObject: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            selectedAmount: '',
            customAmount: '',
            selectedPaymentMethod: '',
            formObject: null,
        }
    },
    watch: {
        selectedPaymentMethod(newVal) {
            const methodArray = newVal.split('-');
            if(methodArray[0] == 'saved'){
                console.log("Saved Method: " ,this.sessionObject.PaymentMethods[methodArray[1]]);
                this.paymentFormSubmit(Object.assign({},this.sessionObject.PaymentMethods[methodArray[1]]));
            } else {
                console.log("New Method: " ,this.sessionObject.PaymentMethodSettings[methodArray[1]]);
                this.paymentFormSubmit(Object.assign({}, this.sessionObject.PaymentMethodSettings[methodArray[1]]));
            }
        },
        showSummary(newVal) {
            console.log('Show summary changed:', newVal);
        }
    },
    computed: {
        finalAmount() {
            if (this.selectedAmount === 'custom') {
                return parseFloat(this.customAmount) || 0;
            }
            return parseFloat(this.selectedAmount) || 0;
        },
        paymentMethodName() {
            if (!this.selectedPaymentMethod) return 'None selected';

            const methodNames = {
                'saved-visa': 'Visa •••• 1234',
                'saved-mastercard': 'Mastercard •••• 5678',
                'saved-bank': 'Chase Bank •••• 9876',
                'saved-paypal': 'PayPal (user@example.com)',
                'new-credit-card': 'New Credit/Debit Card',
                'new-ach': 'New Bank Transfer (ACH)',
                'new-paypal': 'PayPal',
                'new-apple-pay': 'Apple Pay'
            };
            return methodNames[this.selectedPaymentMethod] || 'Unknown';
        },
        showSummary() {
            return this.finalAmount > 0 && this.selectedPaymentMethod !== '';
        },
        canProceed() {
            return this.finalAmount > 0 && this.selectedPaymentMethod !== '';
        },
        paymentFormSubmit(paymentMethod){
            let ccSettings = this.sessionObject.PaymentMethodSettings.find((s) => s.Type === paymentMethod.Type);
            document.getElementById('payment-form-fields').innerHTML = '';
            this.formObject = null;

            this.formObject = GIDX.showPaymentMethodForm('payment-form-fields',{
                merchantSessionId: this.sessionObject.MerchantSessionID, //Must be the same MerchantSessionID provided to the CreateSession API.
                paymentMethodTypes: [paymentMethod.Type],
                tokenizer: ccSettings.Tokenizer,
                onSaving: function (request) {
                    console.log(request);
                    request.paymentMethod.billingAddress = {
                        addressLine1: '123 Main St.',
                        city: 'Houston',
                        stateCode: 'TX',
                        postalCode: '77001'
                    };
                },
                onSaved: async (paymentMethod) => {
                    console.log("Final:", paymentMethod);
                    //The full PaymentMethod object returned from our API is passed to this function.
                    //Use it to populate your CompleteSession request and finalize the transaction.
                    let completeSessionRequest = {
                        MerchantTransactionID: this.sessionObject.MerchantTransactionID,
                        MerchantSessionID: this.sessionObject.MerchantSessionID,
                        PaymentMethod: {
                            Type: paymentMethod.Type,
                            Token: paymentMethod.Token,
                        },
                        PaymentAmount: {
                            PaymentAmount: this.finalAmount,
                            BonusAmount: 0.0,
                            BonusDetails: "No Bonus",
                            FeeAmount: 0.0,
                            TaxAmount: 0.0,
                            OverrideLimit: false,
                            CurrencyCode: 'USD'
                        },
                    };
                    console.log(completeSessionRequest);
                    try{
                        const response = await fetch("/gidx-complete-session", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(completeSessionRequest)
                        });
                        const data = await response.json();
                        alert("Payment Session Complete");
                        window.location.reload();
                        //this.sessionData = data;
                        // this.toggleFundsStart();
                        console.log("complete: ", data);
                    }catch(err){
                        console.log(err);
                    }
                },
                theme: 'material'
            });
        }
    },
    methods: {
        closeModal() {
            this.toggleShowModal();
            // this.$emit('close');
        },
        handleSubmit() {
            if (!this.canProceed) {
                alert('Please select both an amount and payment method');
                return;
            }
            this.formObject.submit();

            let message = `Processing payment of $${this.finalAmount.toFixed(2)} via ${this.paymentMethodName}`;
            console.log(this.sessionObject, message);
        }
    },
    mounted() {
        if(this.sessionObject != null){
            GIDX.init({
                merchantId: this.sessionObject.MerchantID,
                environment: "sandbox"
            });
        } else {
            alert("500 Server Error");
            this.toggleShowModal();
        }
    }
}
</script>

<style scoped>
    .payment-container-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        overflow-y: auto;
        padding: 20px;
        z-index: 1000;
    }

    .payment-container-modal .payment-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 1200px;
        width: 100%;
        margin: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .payment-container-modal .payment-header {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }

    .payment-container-modal .close-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 35px;
        height: 35px;
        border: none;
        background: #da5446;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(218, 84, 70, 0.3);
    }

    .payment-container-modal .close-btn:hover {
        background: #b84332;
        transform: scale(1.1);
    }

    .payment-container-modal .payment-header h1 {
        color: #2d3748;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .payment-container-modal .payment-header p {
        color: #718096;
        font-size: 16px;
    }

    .payment-container-modal .amount-section {
        margin-bottom: 30px;
    }

    .payment-container-modal .section-title {
        color: #2d3748;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .payment-container-modal .section-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 18px;
        background: #da5446;
        border-radius: 2px;
        margin-right: 10px;
    }

    .payment-container-modal .amount-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 10px;
        margin-bottom: 15px;
    }

    .payment-container-modal .amount-option {
        position: relative;
    }

    .payment-container-modal .amount-option input[type="radio"] {
        display: none;
    }

    .payment-container-modal .amount-option label {
        display: block;
        padding: 12px;
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        color: #4a5568;
    }

    .payment-container-modal .amount-option input[type="radio"]:checked + label {
        background: #da5446;
        border-color: #da5446;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(218, 84, 70, 0.3);
    }

    .payment-container-modal .custom-amount {
        margin-top: 10px;
    }

    .payment-container-modal .custom-amount input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .payment-container-modal .custom-amount input:focus {
        outline: none;
        border-color: #da5446;
        box-shadow: 0 0 0 3px rgba(218, 84, 70, 0.1);
    }

    .payment-container-modal .saved-methods {
        margin-bottom: 30px;
    }

    .payment-container-modal .payment-methods {
        margin-bottom: 30px;
    }

    .payment-container-modal .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .payment-container-modal .payment-method-container {
        position: relative;
    }

    .payment-container-modal .payment-method {
        margin-bottom: 15px;
    }

    .payment-container-modal .payment-method input[type="radio"] {
        display: none;
    }

    .payment-container-modal .payment-method label {
        display: flex;
        align-items: center;
        padding: 16px;
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-container-modal .payment-method input[type="radio"]:checked + label {
        background: #fef5f5;
        border-color: #da5446;
        box-shadow: 0 4px 12px rgba(218, 84, 70, 0.15);
    }

    .payment-container-modal .payment-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }

    .payment-container-modal .card-icon {
        background: linear-gradient(45deg, #da5446, #b84332);
    }

    .payment-container-modal .ach-icon {
        background: linear-gradient(45deg, #4ecdc4, #44a08d);
    }

    .payment-container-modal .paypal-icon {
        background: linear-gradient(45deg, #0070ba, #003087);
    }

    .payment-container-modal .apple-icon {
        background: linear-gradient(45deg, #000, #333);
    }

    .payment-container-modal .payment-info {
        flex: 1;
    }

    .payment-container-modal .payment-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 4px;
    }

    .payment-container-modal .payment-details {
        color: #718096;
        font-size: 14px;
    }

    .payment-container-modal .radio-indicator {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e0;
        border-radius: 50%;
        position: relative;
        transition: all 0.3s ease;
    }

    .payment-container-modal .payment-method input[type="radio"]:checked + label .radio-indicator {
        border-color: #da5446;
        background: #da5446;
    }

    .payment-container-modal .payment-method input[type="radio"]:checked + label .radio-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
    }

    .payment-container-modal .payment-form {
        margin-top: 15px;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        animation: slideDown 0.3s ease;
        grid-column: 1 / -1;
        width: 100%;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .payment-container-modal .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .payment-container-modal .form-group {
        display: flex;
        flex-direction: column;
    }

    .payment-container-modal .form-group.full-width {
        grid-column: 1 / -1;
    }

    .payment-container-modal .form-group label {
        color: #2d3748;
        font-weight: 500;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .payment-container-modal .form-group input,
    .payment-container-modal .form-group select {
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
        background: white;
    }

    .payment-container-modal .form-group input:focus,
    .payment-container-modal .form-group select:focus {
        outline: none;
        border-color: #da5446;
        box-shadow: 0 0 0 3px rgba(218, 84, 70, 0.1);
    }

    .payment-container-modal .checkbox-label {
        display: flex !important;
        flex-direction: row !important;
        align-items: center;
        cursor: pointer;
        margin-top: 5px;
    }

    .payment-container-modal .checkbox-label input[type="checkbox"] {
        display: none;
    }

    .payment-container-modal .checkmark {
        width: 18px;
        height: 18px;
        border: 2px solid #cbd5e0;
        border-radius: 4px;
        margin-right: 10px;
        position: relative;
        transition: all 0.3s ease;
    }

    .payment-container-modal .checkbox-label input[type="checkbox"]:checked + .checkmark {
        background: #da5446;
        border-color: #da5446;
    }

    .payment-container-modal .checkbox-label input[type="checkbox"]:checked + .checkmark::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    .payment-container-modal .paypal-connect {
        text-align: center;
        padding: 20px;
    }

    .payment-container-modal .paypal-connect p {
        color: #4a5568;
        margin-bottom: 15px;
    }

    .payment-container-modal .paypal-info {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #0070ba;
    }

    .payment-container-modal .paypal-info div {
        color: #2d3748;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .payment-container-modal .apple-pay-info {
        text-align: center;
        padding: 20px;
    }

    .payment-container-modal .apple-pay-button {
        background: #000;
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        margin-bottom: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .payment-container-modal .apple-pay-button:hover {
        background: #333;
    }

    .payment-container-modal .apple-pay-icon {
        margin-right: 10px;
        font-size: 18px;
    }

    .payment-container-modal .apple-pay-info p {
        color: #4a5568;
        font-size: 14px;
    }

    .payment-container-modal .summary {
        background: #fef5f5;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border-left: 4px solid #da5446;
    }

    .payment-container-modal .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .payment-container-modal .summary-total {
        font-weight: 600;
        font-size: 18px;
        border-top: 1px solid #e2e8f0;
        padding-top: 8px;
        margin-top: 8px;
    }

    .payment-container-modal .button-group {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .payment-container-modal .proceed-btn,
    .payment-container-modal .cancel-btn {
        flex: 1;
        min-width: 150px;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-container-modal .proceed-btn {
        background: linear-gradient(135deg, #da5446, #b84332);
        color: white;
        box-shadow: 0 4px 15px rgba(218, 84, 70, 0.3);
    }

    .payment-container-modal .proceed-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(218, 84, 70, 0.4);
    }

    .payment-container-modal .proceed-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .payment-container-modal .cancel-btn {
        background: #f7fafc;
        color: #4a5568;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .payment-container-modal .cancel-btn:hover {
        background: #edf2f7;
        border-color: #cbd5e0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 1199px) {
        .payment-container-modal .payment-methods-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .payment-container-modal .payment-container {
            padding: 25px;
            margin: 15px;
        }

        .payment-container-modal .payment-methods-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .payment-container-modal .amount-options {
            grid-template-columns: repeat(2, 1fr);
        }

        .payment-container-modal .form-grid {
            grid-template-columns: 1fr;
        }

        .payment-container-modal .payment-header h1 {
            font-size: 24px;
        }

        .payment-container-modal .section-title {
            font-size: 16px;
        }

        .payment-container-modal .button-group {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .payment-container-modal {
            padding: 10px;
        }

        .payment-container-modal .payment-container {
            padding: 20px;
            margin: 0;
        }

        .payment-container-modal .amount-options {
            grid-template-columns: repeat(2, 1fr);
        }

        .payment-container-modal .form-grid {
            grid-template-columns: 1fr;
        }

        .payment-container-modal .payment-form {
            padding: 15px;
        }

        .payment-container-modal .payment-header h1 {
            font-size: 22px;
        }

        .payment-container-modal .payment-method label {
            padding: 12px;
        }

        .payment-container-modal .payment-icon {
            width: 35px;
            height: 35px;
            font-size: 16px;
        }
    }

    @media (min-width: 1200px) {
        .payment-container-modal .payment-methods-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .payment-container-modal .amount-options {
            grid-template-columns: repeat(5, 1fr);
        }
    }
</style>
