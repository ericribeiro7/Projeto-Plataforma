function atualizarListaDemandas() {
    fetch('obterDemandas.php')
        .then(response => response.json())
        .then(data => {
            const listaDemandas = document.getElementById('listaDemandas');
            listaDemandas.innerHTML = ''; // Limpa a lista antes de atualizar

            data.forEach(demanda => {
                const item = document.createElement('li');
                item.innerHTML = `
                    <h3>${demanda.nome}</h3>
                    <p>Tipo: ${demanda.tipo}</p>
                    <p>Quantidade: ${demanda.quantidade}</p>
                    <p>Descrição: ${demanda.descricao}</p>
                    <p>Informações Adicionais: ${demanda.info_adicional}</p>
                `;
                listaDemandas.appendChild(item);
            });
        })
        .catch(error => console.error('Erro ao buscar demandas:', error));
}

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', atualizarListaDemandas);
