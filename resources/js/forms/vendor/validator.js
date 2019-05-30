import { getCEP } from "./api";
import { Validator } from "vee-validate"
import pt_BR from 'vee-validate/dist/locale/pt_BR'
import moment from 'moment'

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

const legalAge = {
    getMessage(field, args, data) {
        return (data && data.message) || `Oops, você precisa ter entre 18 e 120 anos para comprar em nosso site.`;
    },
    validate(value, args) {
        const age = moment().diff(moment(value, "DD/MM/YYYY"), "years")

        return (age >= 18 && age <= 120)
    }
};

const today = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} deve ser maior que o momento atual.`;
    },
    validate(value, args) {
        return moment() < moment(value, 'DD/MM/YYYY HH:mm')
    }
};

const dateAfter = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} deve ser maior que ${args}.`;
    },
    validate(value, args) {
        return moment(value, 'DD/MM/YYYY HH:mm') > moment(args, 'DD/MM/YYYY HH:mm')
    }
};

const dateBefore = {
    getMessage(field, args, data) {
        return (data && data.message) || `O valor do campo ${field} deve ser menor que ${args}.`;
    },
    validate(value, args) {
        return moment(value, 'DD/MM/YYYY HH:mm') < moment(args, 'DD/MM/YYYY HH:mm')
    }
};

Validator.extend('phone', phone);
Validator.extend('cep', cep);
Validator.extend('cnpj', cnpj);
Validator.extend('cpf', cpf);
Validator.extend('document', document);
Validator.extend('legal_age', legalAge);
Validator.extend('today', today);
Validator.extend('date_after', dateAfter);
Validator.extend('date_before', dateBefore);
