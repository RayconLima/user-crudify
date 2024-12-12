const itiFormat = (value: string) => {
    const iti = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    return iti;
}

export { itiFormat }