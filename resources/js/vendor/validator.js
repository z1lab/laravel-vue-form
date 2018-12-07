import { getCEP } from "./api";
import { Validator } from "vee-validate"
import pt_BR from 'vee-validate/dist/locale/pt_BR'

Validator.localize('pt_BR', pt_BR)

const phone = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} não é válido.`
    },
    validate(value, args) {
        return !_.isNull(value.match(/^\d{10}(\d)?$/));
    }
};

const cep = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} não é válido.`
    },
    async validate(value, args) {
        if (value.length === 8) {
            let valid = await getCEP(value)

            return _.isUndefined(valid.data.erro)
        }

        return false
    }
};

const cnpj = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} não é válido.`;
    },
    validate(value, args) {
        return !_.isNull(value.match(/^\d{14}$/));
    }
};


const cpf = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} não é válido.`;
    },
    validate(value, args) {
        return !_.isNull(value.match(/^\d{11}$/));
    }
};

const document = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} não é válido.`;
    },
    validate(value, args) {
        return !_.isNull(value.match(/^\d{11}(\d{3})?$/))
    }
};

Validator.extend('phone', phone);
Validator.extend('cep', cep);
Validator.extend('cnpj', cnpj);
Validator.extend('cpf', cpf);
Validator.extend('document', document);
