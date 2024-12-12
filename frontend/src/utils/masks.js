const formatITI = (iti) => {
    const cleaned = ('' + iti).replace(/\D/g, '');

    if (cleaned.length !== 11) {
        return iti;
    }

    const formatted = cleaned.replace(/(\d{3})(\d)/, '$1.$2')
                             .replace(/(\d{3})(\d)/, '$1.$2')
                             .replace(/(\d{3})(\d{2})$/, '$1-$2');

    return formatted;
}

export {
    formatITI
}