<style>
.tut-wrap { display:flex; gap:24px; align-items:flex-start; }

.tut-toc {
    width:260px; flex-shrink:0; position:sticky; top:20px;
    background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px;
    padding:16px; max-height:calc(100vh - 40px); overflow-y:auto;
}
.tut-toc input {
    width:100%; background:#1e2133; border:1px solid #444860; color:#e8eaf0;
    border-radius:8px; padding:8px 12px; font-size:12.5px; margin-bottom:14px; box-sizing:border-box;
}
.tut-toc input:focus { outline:none; border-color:#a78bfa; }
.tut-toc-grupo { font-size:10px; font-weight:800; color:#6b7280; text-transform:uppercase; letter-spacing:.6px; margin:14px 0 6px; }
.tut-toc-grupo:first-child { margin-top:0; }
.tut-toc a {
    display:flex; align-items:center; gap:8px; padding:7px 9px; border-radius:7px;
    color:#c9cad6; text-decoration:none; font-size:12.5px; transition:background .12s;
}
.tut-toc a:hover, .tut-toc a.ativo { background:rgba(167,139,250,0.12); color:#a78bfa; }
.tut-toc a i { font-size:14px; flex-shrink:0; }

.tut-content { flex:1; min-width:0; }
.tut-intro { background:linear-gradient(135deg,rgba(167,139,250,0.1),rgba(124,58,237,0.05)); border:1px solid rgba(167,139,250,0.2); border-radius:14px; padding:20px; margin-bottom:20px; }
.tut-intro h1 { font-size:22px; color:#e8eaf0; margin-bottom:8px; }
.tut-intro p { color:#9ca3af; font-size:13.5px; line-height:1.6; }

.tut-secao { background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px; margin-bottom:14px; overflow:hidden; scroll-margin-top:20px; }
.tut-secao-head { padding:16px 20px; display:flex; align-items:center; gap:12px; cursor:pointer; user-select:none; }
.tut-secao-icon { width:38px; height:38px; border-radius:10px; background:rgba(167,139,250,0.15); color:#a78bfa; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.tut-secao-titulo { font-size:15.5px; font-weight:700; color:#e8eaf0; flex:1; }
.tut-secao-toggle { color:#6b7280; font-size:18px; transition:transform .2s; }
.tut-secao.aberta .tut-secao-toggle { transform:rotate(180deg); }
.tut-secao-body { padding:0 20px 20px; display:none; }
.tut-secao.aberta .tut-secao-body { display:block; }

.tut-secao-body h4 { color:#a78bfa; font-size:13px; font-weight:700; margin:16px 0 8px; }
.tut-secao-body h4:first-child { margin-top:0; }
.tut-secao-body p { color:#c9cad6; font-size:13.5px; line-height:1.65; margin-bottom:8px; }
.tut-secao-body ul { margin:8px 0 8px 0; padding-left:20px; }
.tut-secao-body li { color:#c9cad6; font-size:13.5px; line-height:1.7; }
.tut-secao-body strong { color:#e8eaf0; }
.tut-dica { background:rgba(34,197,94,0.08); border-left:3px solid #22c55e; border-radius:0 8px 8px 0; padding:10px 14px; margin:10px 0; font-size:12.5px; color:#a7f3d0; }
.tut-dica strong { color:#4ade80; }
.tut-atalho { display:inline-block; background:#252a3a; border:1px solid #444860; border-radius:6px; padding:1px 8px; font-family:monospace; font-size:11.5px; color:#e8eaf0; }

.tut-nomatch { display:none; }
</style>

<div class="new122">
    <div class="tut-intro">
        <h1><i class='bx bx-book-open'></i> Manual do Sistema — SISOS</h1>
        <p>Guia completo de todas as áreas do sistema. Use a busca ao lado pra achar rápido o que precisa, ou clique nos títulos abaixo pra expandir cada seção.</p>
    </div>

    <div class="tut-wrap">
        <!-- Índice / Busca -->
        <div class="tut-toc">
            <input type="text" id="tutBusca" placeholder="Buscar no manual..." oninput="tutFiltrar(this.value)">

            <div class="tut-toc-grupo">Começando</div>
            <a href="#sec-visao-geral"><i class='bx bx-grid-alt'></i> Visão Geral</a>
            <a href="#sec-atalhos"><i class='bx bx-keyboard'></i> Atalhos de Teclado</a>

            <div class="tut-toc-grupo">Atendimento</div>
            <a href="#sec-clientes"><i class='bx bx-group'></i> Clientes</a>
            <a href="#sec-produtos"><i class='bx bx-basket'></i> Produtos e Estoque</a>
            <a href="#sec-servicos"><i class='bx bx-wrench'></i> Serviços</a>
            <a href="#sec-os"><i class='bx bx-file-blank'></i> Ordens de Serviço</a>
            <a href="#sec-mesa"><i class='bx bx-grid-alt'></i> Mesa de Trabalho</a>
            <a href="#sec-vendas"><i class='bx bx-cart-alt'></i> Vendas</a>

            <div class="tut-toc-grupo">Pós-Atendimento</div>
            <a href="#sec-posvenda"><i class='bx bx-message-rounded-dots'></i> Pós-Venda</a>
            <a href="#sec-solucoes"><i class='bx bx-bulb'></i> Soluções Técnicas</a>
            <a href="#sec-satisfacao"><i class='bx bx-star'></i> Pesquisa de Satisfação</a>

            <div class="tut-toc-grupo">Interno / Equipe</div>
            <a href="#sec-pedidos"><i class='bx bx-task'></i> Pedidos e Anotações</a>
            <a href="#sec-chat"><i class='bx bx-chat'></i> Chat da Equipe</a>

            <div class="tut-toc-grupo">Financeiro</div>
            <a href="#sec-financeiro"><i class='bx bx-dollar-circle'></i> Lançamentos e Caixa</a>
            <a href="#sec-relatorios"><i class='bx bx-pie-chart-alt-2'></i> Relatórios</a>

            <div class="tut-toc-grupo">Sistema</div>
            <a href="#sec-config"><i class='bx bx-cog'></i> Configurações</a>
            <a href="#sec-permissoes"><i class='bx bx-lock-alt'></i> Usuários e Permissões</a>
        </div>

        <!-- Conteúdo -->
        <div class="tut-content" id="tutConteudo">

            <div class="tut-secao aberta" id="sec-visao-geral">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-grid-alt'></i></div>
                    <div class="tut-secao-titulo">Visão Geral do Sistema</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>O SISOS é o sistema de gestão da assistência técnica — organiza tudo desde o momento que um cliente chega com um aparelho até a entrega final e o acompanhamento pós-venda.</p>
                    <h4>Como o sistema é organizado</h4>
                    <ul>
                        <li><strong>Menu lateral (esquerda):</strong> acesso às telas principais — Clientes, Produtos, Serviços, Ordens de Serviço, Vendas, Financeiro, etc.</li>
                        <li><strong>Menu superior (topo):</strong> ícones de Perfil, Relatórios, Notificações (sino) e Configurações.</li>
                        <li><strong>Sininho de notificações:</strong> avisa automaticamente sobre OS com prazo vencido, estoque baixo, pagamentos pendentes e aniversariantes do dia — clicando, já abre a lista filtrada certinha.</li>
                    </ul>
                    <div class="tut-dica"><strong>Dica:</strong> sempre que uma tela tiver um campo de busca, você pode digitar nome, número de OS, telefone ou documento — o sistema busca em vários campos ao mesmo tempo.</div>
                </div>
            </div>

            <div class="tut-secao" id="sec-atalhos">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-keyboard'></i></div>
                    <div class="tut-secao-titulo">Atalhos de Teclado</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Esses atalhos funcionam em qualquer tela do sistema, sem precisar clicar em nada primeiro:</p>
                    <ul>
                        <li><span class="tut-atalho">Esc</span> — volta pro início (dashboard)</li>
                        <li><span class="tut-atalho">F1</span> — vai direto pra Clientes</li>
                        <li><span class="tut-atalho">F2</span> — vai direto pra Produtos</li>
                        <li><span class="tut-atalho">F3</span> — vai pro PDV (se estiver ativado) ou Serviços</li>
                        <li><span class="tut-atalho">F4</span> — vai direto pra Ordens de Serviço</li>
                        <li><span class="tut-atalho">F5</span> — abre direto o formulário de Nova OS</li>
                        <li><span class="tut-atalho">F6</span> — abre direto o formulário de Nova Venda</li>
                        <li><span class="tut-atalho">F7</span> — vai pro Assistente de IA (se ativado) ou Lançamentos Financeiros</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-clientes">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-group'></i></div>
                    <div class="tut-secao-titulo">Clientes</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Cadastro de todos os clientes e fornecedores da loja.</p>
                    <h4>O que dá pra fazer</h4>
                    <ul>
                        <li><strong>Cadastrar:</strong> nome, CPF/CNPJ, telefone, celular/WhatsApp, e-mail, endereço e data de nascimento.</li>
                        <li><strong>Notificar aniversário:</strong> ao cadastrar, existe um botão pra ligar o aviso de aniversário — o sistema avisa automaticamente no sininho no dia certo.</li>
                        <li><strong>Bloquear cliente:</strong> pra impedir que ele tenha acesso à Área do Cliente ou abra novas OS (precisa registrar o motivo).</li>
                        <li><strong>Ver Ficha:</strong> mostra o histórico completo daquele cliente — OS anteriores, vendas, dados de contato.</li>
                        <li><strong>Área do Cliente:</strong> ícone de chave leva direto pro portal que o próprio cliente usa (sem precisar da senha dele).</li>
                        <li><strong>Tags / Categorias:</strong> dá pra criar etiquetas coloridas (ex: "Contrato Bronze", "Contrato Ouro") e atribuir a cada cliente, pra identificar rápido o tipo de contrato ou perfil dele. A lista pode ser filtrada por tag.</li>
                        <li><strong>Filtrar por fornecedor:</strong> um filtro na listagem mostra só os clientes marcados como fornecedor.</li>
                    </ul>
                    <div class="tut-dica"><strong>Dica:</strong> antes de cadastrar um cliente novo, sempre vale buscar pelo telefone primeiro — muita gente já tem cadastro de uma visita anterior.</div>
                </div>
            </div>

            <div class="tut-secao" id="sec-produtos">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-basket'></i></div>
                    <div class="tut-secao-titulo">Produtos e Estoque</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Catálogo de peças e produtos, com controle de estoque e preços.</p>
                    <h4>Campos importantes</h4>
                    <ul>
                        <li><strong>Preço de compra e venda:</strong> a diferença entre os dois é a margem do produto.</li>
                        <li><strong>Estoque mínimo:</strong> quando o estoque chega nesse valor (ou abaixo), o produto aparece no aviso de "Estoque Baixo" no sininho.</li>
                        <li><strong>Atualizar estoque:</strong> use sempre esse botão específico pra adicionar quantidade — nunca edite o campo de estoque direto pra somar, pois pode duplicar o valor.</li>
                    </ul>
                    <h4>Etiquetas</h4>
                    <p>É possível gerar etiquetas com código de barras pra colar nos produtos físicos, escolhendo um intervalo de IDs.</p>
                </div>
            </div>

            <div class="tut-secao" id="sec-servicos">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-wrench'></i></div>
                    <div class="tut-secao-titulo">Serviços</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Tabela de preços dos serviços prestados (troca de tela, bateria, reparo de placa, etc). Cada serviço tem nome, preço base e uma descrição opcional — esses valores são usados na hora de montar o orçamento de uma OS.</p>
                </div>
            </div>

            <div class="tut-secao" id="sec-os">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-file-blank'></i></div>
                    <div class="tut-secao-titulo">Ordens de Serviço (OS)</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>O coração do sistema — cada aparelho que entra pra reparo vira uma OS.</p>
                    <h4>Ao criar uma OS</h4>
                    <ul>
                        <li>Cliente, técnico responsável, equipamento, defeito relatado e datas.</li>
                        <li><strong>Checklist de entrada (obrigatório):</strong> marca o estado do aparelho na chegada (tela, bateria, botões, etc.) — protege a loja em caso de reclamação futura. O sistema não deixa salvar a OS enquanto algum item do checklist não estiver marcado.</li>
                        <li><strong>Senha do celular:</strong> registra o tipo (PIN, Padrão, Face ID, Digital) e o valor, se precisar desbloquear pra testar.</li>
                        <li><strong>Status:</strong> Aberto, Orçamento, Em Andamento, Aguardando Peças, Finalizado, Faturado, Cancelado, entre outros.</li>
                    </ul>
                    <h4>Recursos na tela da OS</h4>
                    <ul>
                        <li><strong>Faturar:</strong> gera a cobrança final, considerando produtos, serviços e desconto.</li>
                        <li><strong>Garantia Digital:</strong> gera um QR Code que o cliente escaneia pra ver o termo de garantia daquele reparo.</li>
                        <li><strong>Link de Acompanhamento:</strong> gera um link único (sem precisar de login) onde o cliente acompanha o status do reparo em tempo real, e pode até <strong>aprovar ou recusar o orçamento</strong> direto por lá.</li>
                        <li><strong>Etiqueta QR:</strong> etiqueta pequena pra colar no próprio aparelho, com QR apontando pro Link de Acompanhamento.</li>
                        <li><strong>Assinatura na Entrega:</strong> colhe a assinatura digital do cliente (no computador ou tablet) confirmando o recebimento do aparelho.</li>
                        <li><strong>Sugestão de Diagnóstico (IA):</strong> com base no defeito relatado, a inteligência artificial sugere possíveis causas e próximos passos.</li>
                    </ul>
                    <div class="tut-dica"><strong>Dica:</strong> o campo "Entregue ao Cliente" é separado do Status — uma OS pode estar Finalizada mas ainda não ter sido retirada pelo cliente.</div>
                </div>
            </div>

            <div class="tut-secao" id="sec-mesa">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-grid-alt'></i></div>
                    <div class="tut-secao-titulo">Mesa de Trabalho</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Visão em quadro (tipo painel de tarefas) de todas as OS em andamento, organizadas em colunas por etapa: Novo/Orçamento, Aguardando Peça, Em Serviço, Pronto, Entregue/Faturado.</p>
                    <ul>
                        <li><strong>Arrastar um card</strong> pra outra coluna muda o status da OS automaticamente — funciona tanto com mouse quanto com o dedo (tablet).</li>
                        <li>A faixinha colorida na lateral do card mostra há quanto tempo aquela OS está parada naquela etapa: verde (recente), amarelo (atenção), vermelho (demorando muito).</li>
                        <li>O menu "⋮" em cada card dá acesso rápido a Ver, Editar, Imprimir e Excluir.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-vendas">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-cart-alt'></i></div>
                    <div class="tut-secao-titulo">Vendas</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Registro de vendas avulsas de produtos (não vinculadas a uma OS de reparo) — pra quando o cliente compra um acessório, película, capinha, etc., sem estar consertando nada.</p>
                    <ul>
                        <li><strong>Cancelar venda:</strong> devolve automaticamente o estoque dos produtos e remove o lançamento financeiro vinculado.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-posvenda">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-message-rounded-dots'></i></div>
                    <div class="tut-secao-titulo">Pós-Venda</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Ajuda a não esquecer de fazer follow-up com clientes depois que o reparo foi entregue.</p>
                    <ul>
                        <li>Em <strong>Configurar</strong>, você cadastra modelos de mensagem com um prazo (ex: "3 dias depois de finalizar, manda isso") e o link de avaliação do Google.</li>
                        <li>No painel principal, todo dia aparecem os clientes que já bateram o prazo de algum modelo — é só clicar em "Enviar no WhatsApp".</li>
                    </ul>
                    <div class="tut-dica"><strong>Importante:</strong> o envio não é automático — alguém precisa entrar na tela e clicar pra mandar. O sistema só lembra quem está no prazo.</div>
                </div>
            </div>

            <div class="tut-secao" id="sec-solucoes">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-bulb'></i></div>
                    <div class="tut-secao-titulo">Soluções Técnicas</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Base de conhecimento da equipe — quando um técnico resolve um problema difícil ou incomum, ele registra aqui: qual era o problema, como foi resolvido, com fotos e vídeo se quiser.</p>
                    <p>A busca acha por palavras no título, equipamento, problema ou solução — útil pra quando aparecer um caso parecido no futuro, mesmo que seja outro técnico atendendo.</p>
                </div>
            </div>

            <div class="tut-secao" id="sec-satisfacao">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-star'></i></div>
                    <div class="tut-secao-titulo">Pesquisa de Satisfação</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Depois que uma OS é finalizada, o cliente pode receber um link pra avaliar o atendimento — dá nota e, se quiser, deixa um comentário.</p>
                    <ul>
                        <li>As respostas ficam registradas no sistema e ajudam a acompanhar a satisfação geral, além de sinalizar atendimentos que podem precisar de atenção.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-pedidos">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-task'></i></div>
                    <div class="tut-secao-titulo">Pedidos e Anotações</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Quadro estilo Kanban pra organizar pedidos internos, encomendas de peças ou anotações da equipe, com colunas por etapa (ex: Pendente, Em Andamento, Concluído).</p>
                    <ul>
                        <li><strong>Fotos:</strong> cada cartão aceita uma ou mais fotos anexadas (ex: foto da peça encomendada, print de conversa).</li>
                        <li><strong>Notificar por WhatsApp:</strong> dá pra mandar um aviso direto pro WhatsApp do responsável quando o cartão muda de status.</li>
                        <li><strong>Arrastar cartão:</strong> igual à Mesa de Trabalho — arrastar entre colunas atualiza o status automaticamente.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-chat">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-chat'></i></div>
                    <div class="tut-secao-titulo">Chat da Equipe</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Chat interno pra comunicação rápida entre os funcionários, direto pelo sistema, sem depender de WhatsApp ou outro aplicativo externo.</p>
                    <ul>
                        <li><strong>Geral:</strong> conversa em grupo, visível pra todos que têm acesso ao sistema.</li>
                        <li><strong>Conversas privadas:</strong> mensagem direta entre dois usuários.</li>
                        <li><strong>Não lidas:</strong> um contador avisa quantas mensagens novas chegaram, tanto no Geral quanto nas privadas.</li>
                    </ul>
                    <div class="tut-dica"><strong>Dica:</strong> o chat atualiza sozinho a cada poucos segundos — não precisa ficar recarregando a página.</div>
                </div>
            </div>

            <div class="tut-secao" id="sec-financeiro">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-dollar-circle'></i></div>
                    <div class="tut-secao-titulo">Lançamentos e Caixa</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Controle financeiro da loja — receitas e despesas.</p>
                    <ul>
                        <li><strong>Lançamentos:</strong> lista de tudo que entrou e saiu, com filtro por período, status (pago/pendente) e tipo.</li>
                        <li><strong>Dashboard Financeiro:</strong> gráficos e resumo geral de entradas/saídas.</li>
                        <li><strong>Caixa:</strong> controle de abertura/fechamento de caixa do dia.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-relatorios">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-pie-chart-alt-2'></i></div>
                    <div class="tut-secao-titulo">Relatórios</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Acessível pelo ícone de gráfico no topo da tela. Todos os relatórios geram um PDF pra imprimir ou salvar.</p>
                    <ul>
                        <li><strong>Clientes, Produtos, Serviços, OS, Vendas:</strong> listagens detalhadas de cada área.</li>
                        <li><strong>Produtos Mais Vendidos / Serviços Mais Feitos:</strong> ranking por quantidade — ajuda a saber o que priorizar no estoque e no treinamento da equipe.</li>
                        <li><strong>Comissão por Técnico:</strong> quanto cada técnico gerou em serviços.</li>
                        <li><strong>Lucratividade:</strong> margem entre custo e venda.</li>
                        <li><strong>SKU:</strong> cruzamento de vendas e OS por produto.</li>
                        <li><strong>Receitas Brutas — MEI:</strong> pra declaração do MEI.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-config">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-cog'></i></div>
                    <div class="tut-secao-titulo">Configurações</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <ul>
                        <li><strong>Sistema:</strong> tema visual, templates de WhatsApp, configuração de IA.</li>
                        <li><strong>Emitente:</strong> dados da sua empresa (nome, CNPJ, endereço, logo) — aparecem nos PDFs e impressões.</li>
                        <li><strong>Auditoria:</strong> registro de quem fez o quê e quando no sistema.</li>
                        <li><strong>Backup:</strong> geração de cópia de segurança dos dados.</li>
                    </ul>
                </div>
            </div>

            <div class="tut-secao" id="sec-permissoes">
                <div class="tut-secao-head" onclick="tutToggle(this)">
                    <div class="tut-secao-icon"><i class='bx bx-lock-alt'></i></div>
                    <div class="tut-secao-titulo">Usuários e Permissões</div>
                    <i class='bx bx-chevron-down tut-secao-toggle'></i>
                </div>
                <div class="tut-secao-body">
                    <p>Cada funcionário tem um usuário próprio, com um perfil de permissões que controla o que ele pode ver, adicionar, editar ou excluir em cada área do sistema.</p>
                    <div class="tut-dica"><strong>Dica pra quem está treinando funcionário novo:</strong> comece com um perfil mais restrito (só visualizar e adicionar OS, por exemplo) e vá liberando mais permissões conforme a pessoa ganha confiança no sistema.</div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function tutToggle(head) {
    head.closest('.tut-secao').classList.toggle('aberta');
}

function tutFiltrar(q) {
    q = q.toLowerCase().trim();
    var secoes = document.querySelectorAll('#tutConteudo .tut-secao');
    secoes.forEach(function(sec) {
        if (!q) {
            sec.style.display = '';
            return;
        }
        var texto = sec.textContent.toLowerCase();
        var acha = texto.indexOf(q) > -1;
        sec.style.display = acha ? '' : 'none';
        if (acha) sec.classList.add('aberta'); // abre automaticamente quem bateu na busca
    });
}
</script>
