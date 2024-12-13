export const getStatus = (status) => {
    switch (status) {
        case 'active':
            return 'Ativo';
        case 'pending':
            return 'Pendente';
        case 'inactive':
            return 'Inativo';
        default:
            return 'Erro de status';
    }

}
