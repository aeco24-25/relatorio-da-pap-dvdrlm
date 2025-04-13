USE dteaches;

-- Inserir categorias
INSERT INTO categoria (titulo) VALUES 
('Saudações e Apresentações'),
('No Hotel'),
('Restaurantes e Alimentação'),
('Transportes'),
('Emergências'),
('Compras'),
('Direções e Localizações'),
('Trabalho e Negócios'),
('Tecnologia e Internet'),
('Lazer e Entretenimento');

-- =============================================
-- SAUDAÇÕES E APRESENTAÇÕES
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('Hello, how are you?', 'Olá, como estás?', 1, 'Forma comum de cumprimentar alguém em inglês. Pode ser usado em qualquer situação, formal ou informal.'),
('Good morning!', 'Bom dia!', 1, 'Usado até aproximadamente meio-dia. Em situações formais, pode ser seguido pelo nome da pessoa.'),
('Good afternoon!', 'Boa tarde!', 1, 'Usado geralmente entre o meio-dia e as 18h. Adequado para situações formais e informais.'),
('Good evening!', 'Boa noite!', 1, 'Usado como cumprimento a partir do final da tarde até à noite. Não confundir com "Good night" que é usado para despedidas.'),
('My name is...', 'Chamo-me...', 1, 'Frase essencial para se apresentar. Em contextos informais, pode-se usar apenas "I\'m..."'),
('Nice to meet you!', 'Prazer em conhecer-te!', 1, 'Usado quando se conhece alguém pela primeira vez. Em situações formais, pode-se dizer "Pleased to meet you"'),
('Where are you from?', 'De onde és?', 1, 'Pergunta comum em conversas iniciais. Resposta típica: "I\'m from..." seguido do país/cidade.'),
('I am from Portugal', 'Sou de Portugal', 1, 'Resposta padrão para indicar origem. Note que países sempre começam com letra maiúscula em inglês.'),
('Do you speak English?', 'Falas inglês?', 1, 'Pergunta útil quando não se tem certeza sobre o idioma do interlocutor.'),
('I don''t speak English very well', 'Não falo inglês muito bem', 1, 'Frase útil para indicar que o seu inglês é limitado. Pode ser seguida por "Could you speak slowly, please?"');

-- Exemplos para Saudações e Apresentações
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(1, '"Hello, how are you?" disse o colega quando me viu chegar.'),
(2, '"Good morning, Dr. Silva!" cumprimentou a enfermeira.'),
(3, 'Ao entrar na loja, ouvi um alegre "Good afternoon!"'),
(4, '"Good evening, everyone!" anunciou o apresentador.'),
(5, '"My name is Pedro" apresentei-me aos novos colegas.'),
(6, '"Nice to meet you," respondeu ela com um aperto de mão.'),
(7, '"Where are you from?" perguntou o taxista curioso.'),
(8, 'Quando perguntado, respondi "I am from Lisbon, Portugal"'),
(9, '"Do you speak English?" perguntei ao funcionário do museu.'),
(10, '"I don\'t speak English very well" admiti, pedindo paciência.');

-- =============================================
-- NO HOTEL
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('I have a reservation', 'Tenho uma reserva', 2, 'Frase essencial ao chegar ao hotel. Geralmente seguida pelo nome sob o qual a reserva foi feita.'),
('What time is check-out?', 'A que horas é a saída?', 2, 'Pergunta importante para planear a sua partida. A maioria dos hotéis tem check-out ao meio-dia.'),
('Is breakfast included?', 'O pequeno-almoço está incluído?', 2, 'Pergunta sobre serviços incluídos no preço. Alguns hotéis oferecem pequeno-almoço gratuito.'),
('Do you have WiFi?', 'Têm internet sem fios?', 2, 'Pergunta sobre internet disponível. Pode-se acrescentar "Is it free?" para saber se é gratuito.'),
('The air conditioning is not working', 'O ar condicionado não está a funcionar', 2, 'Frase para reportar problemas no quarto. Pode ser adaptada para outros problemas.'),
('Can I have more towels, please?', 'Posso ter mais toalhas, por favor?', 2, 'Pedido comum para a equipa do hotel. Pode substituir "towels" por outros itens.'),
('Where is the elevator?', 'Onde fica o elevador?', 2, 'Pergunta sobre localização no hotel. Em inglês britânico diz-se "lift".'),
('What floor is my room on?', 'Em que andar fica o meu quarto?', 2, 'Pergunta sobre localização do quarto. Normalmente informado no check-in.'),
('Can you recommend a good restaurant nearby?', 'Pode recomendar um bom restaurante aqui perto?', 2, 'Pedido de recomendação à receção do hotel.'),
('I would like to extend my stay', 'Gostaria de prolongar a minha estadia', 2, 'Frase para solicitar mais dias no hotel.');

-- Exemplos para No Hotel
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(11, '"I have a reservation under the name Oliveira" disse ao rececionista.'),
(12, '"What time is check-out?" perguntei para planear a viagem.'),
(13, '"Is breakfast included?" queria saber se podia comer no hotel.'),
(14, '"Do you have WiFi in the rooms?" perguntei ao fazer check-in.'),
(15, 'Liguei para a receção: "The air conditioning is not working in room 304"'),
(16, '"Can I have more towels, please?" pedi à empregada de limpeza.'),
(17, '"Where is the elevator?" perguntei com as malas pesadas.'),
(18, 'Esqueci-me: "What floor is my room on?"'),
(19, '"Can you recommend a good restaurant nearby for fish?"'),
(20, '"I would like to extend my stay for two more nights" solicitei.');

-- =============================================
-- RESTAURANTES E ALIMENTAÇÃO
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('A table for two, please', 'Uma mesa para dois, por favor', 3, 'Pedido básico ao chegar ao restaurante. Substitua "two" pelo número de pessoas.'),
('Can I see the menu, please?', 'Posso ver a ementa, por favor?', 3, 'Pedido para ver o cardápio. Em alguns lugares o menu é chamado de "bill of fare".'),
('What do you recommend?', 'O que recomenda?', 3, 'Pergunta para obter sugestões do empregado de mesa.'),
('I am vegetarian', 'Sou vegetariano', 3, 'Informação importante sobre restrições alimentares.'),
('I am allergic to...', 'Sou alérgico a...', 3, 'Frase crucial para alergias alimentares. Complete com o alergénio.'),
('Can I have the bill, please?', 'Pode trazer a conta, por favor?', 3, 'Pedido para pagar a conta. Nos EUA é comum dizer "check".'),
('Is service included?', 'O serviço está incluído?', 3, 'Pergunta sobre gorjeta. Em Portugal normalmente já vem incluída.'),
('How spicy is this dish?', 'Quão picante é este prato?', 3, 'Pergunta importante para quem não tolera comida muito picante.'),
('Do you accept credit cards?', 'Aceitam cartão de crédito?', 3, 'Pergunta sobre formas de pagamento.'),
('It was delicious!', 'Estava delicioso!', 3, 'Elogio à comida. Pode usar "The food was excellent".');

-- Exemplos para Restaurantes e Alimentação
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(21, '"A table for two, please" pedimos ao maître.'),
(22, '"Can I see the menu, please?" pedi ao empregado.'),
(23, '"What do you recommend from the seafood dishes?"'),
(24, 'Informei: "I am vegetarian. Are there vegetarian options?"'),
(25, '"I am allergic to nuts" avisei antes de pedir a sobremesa.'),
(26, 'No final da refeição: "Can I have the bill, please?"'),
(27, '"Is service included?" perguntei antes de deixar gorjeta.'),
(28, '"How spicy is this dish? I prefer mild food"'),
(29, '"Do you accept credit cards or just cash?"'),
(30, 'Ao sair: "It was delicious! We\'ll come back!"');

-- =============================================
-- TRANSPORTES
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('How do I get to the city center?', 'Como chego ao centro da cidade?', 4, 'Pergunta básica sobre direções. Pode substituir "city center" por qualquer outro local.'),
('Where is the nearest bus stop?', 'Onde fica a paragem de autocarro mais próxima?', 4, 'Pergunta sobre transporte público. Para "metro" use "subway station" (EUA) ou "underground station" (UK).'),
('I need a ticket to...', 'Preciso de um bilhete para...', 4, 'Frase para comprar passagens. Complete com o destino desejado.'),
('What time is the next train?', 'A que horas é o próximo comboio?', 4, 'Pergunta sobre horários. Para autocarro, substitua "train" por "bus".'),
('Is this the right bus for...?', 'Este é o autocarro certo para...?', 4, 'Pergunta para confirmar se está no veículo correto. Sempre verifique com o motorista.'),
('How much is a taxi to the airport?', 'Quanto custa um táxi para o aeroporto?', 4, 'Pergunta sobre preço de táxi. Algumas cidades têm tarifas fixas para o aeroporto.'),
('Can you take me to this address?', 'Pode levar-me para este endereço?', 4, 'Frase para dar o destino ao taxista. Tenha o endereço escrito para mostrar.'),
('Where can I rent a car?', 'Onde posso alugar um carro?', 4, 'Pergunta sobre locadoras. Pode acrescentar "What documents do I need?" sobre requisitos.'),
('Is there a metro station nearby?', 'Há alguma estação de metro por perto?', 4, 'Pergunta sobre transporte subterrâneo. Em algumas cidades é chamado de "subway" ou "tube".'),
('Which platform does the train leave from?', 'De qual plataforma parte o comboio?', 4, 'Pergunta importante em estações grandes. Verifique sempre os painéis eletrónicos.');

-- Exemplos para Transportes
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(31, '"How do I get to the city center from here?" perguntei ao polícia.'),
(32, '"Where is the nearest bus stop for line 28?"'),
(33, '"I need a ticket to Porto, please" disse na bilheteira.'),
(34, '"What time is the next train to Coimbra?" verifiquei no painel.'),
(35, '"Is this the right bus for the shopping center?" confirmei.'),
(36, '"How much is a taxi to the airport? We\'re four people"'),
(37, '"Can you take me to this address in Alfama?" mostrei ao taxista.'),
(38, '"Where can I rent a car with automatic transmission?"'),
(39, '"Is there a metro station nearby that goes to the airport?"'),
(40, '"Which platform does the train to Braga leave from?"');

-- =============================================
-- EMERGÊNCIAS
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('Help!', 'Socorro!', 5, 'Palavra universal para pedir ajuda em situações urgentes. Gritar para chamar atenção.'),
('I need a doctor', 'Preciso de um médico', 5, 'Frase essencial em emergências médicas. Pode acrescentar "urgently" para maior urgência.'),
('Call an ambulance, please!', 'Chame uma ambulância, por favor!', 5, 'Pedido para emergências médicas graves. Em Portugal disque 112.'),
('Where is the nearest hospital?', 'Onde fica o hospital mais próximo?', 5, 'Pergunta crucial em emergências. Pode usar "pharmacy" para farmácia de serviço.'),
('I lost my passport', 'Perdi o meu passaporte', 5, 'Frase para reportar documento perdido. Deve-se contactar também a embaixada.'),
('I''ve been robbed', 'Fui assaltado', 5, 'Frase para reportar roubo à polícia. Pode usar "My bag was stolen" para itens específicos.'),
('Where is the police station?', 'Onde fica a esquadra da polícia?', 5, 'Pergunta para localizar a polícia. Em Portugal pode perguntar por "PSP" ou "GNR".'),
('I am not feeling well', 'Não me estou a sentir bem', 5, 'Frase para indicar mal-estar. Pode especificar sintomas como "dizzy" (tonturas).'),
('Is there a pharmacy nearby?', 'Há alguma farmácia por perto?', 5, 'Pergunta para encontrar medicamentos. Farmácias de serviço são "on-duty pharmacies".'),
('I am allergic to this medication', 'Sou alérgico a esta medicação', 5, 'Frase importante em tratamentos médicos. Liste todas as alergias conhecidas.');

-- Exemplos para Emergências
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(41, '"Help! Someone call for help!" gritei quando vi o acidente.'),
(42, '"I need a doctor, my friend has fainted" disse desesperado.'),
(43, '"Call an ambulance, please! It\'s an emergency!"'),
(44, '"Where is the nearest hospital with emergency care?"'),
(45, '"I lost my passport and wallet on the tram" reportei à polícia.'),
(46, '"I\'ve been robbed near the train station"'),
(47, '"Where is the police station? I need to file a report"'),
(48, '"I am not feeling well, I think it might be food poisoning"'),
(49, '"Is there a pharmacy nearby that\'s open now?"'),
(50, '"I am allergic to penicillin. Don\'t give me any" avisei o médico.');

-- =============================================
-- COMPRAS
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('How much does this cost?', 'Quanto custa isto?', 6, 'Pergunta básica sobre preço. Aponte para o item se não souber o nome em inglês.'),
('Do you have this in a different size?', 'Tem isto noutro tamanho?', 6, 'Pergunta sobre tamanhos disponíveis. Especifique "smaller" (menor) ou "larger" (maior).'),
('Can I try it on?', 'Posso experimentar?', 6, 'Pedido para provar roupas. Os provadores são chamados de "fitting rooms".'),
('I''m just looking, thanks', 'Estou só a ver, obrigado', 6, 'Frase educada quando não quer comprar imediatamente. Útil para evitar pressão de vendedores.'),
('Do you accept euros?', 'Aceitam euros?', 6, 'Pergunta sobre moeda aceite. Fora da zona euro, muitas lojas aceitam euros com câmbio desfavorável.'),
('That''s too expensive', 'Isso é demasiado caro', 6, 'Frase para negociar ou expressar que está acima do orçamento.'),
('Can you give me a discount?', 'Pode fazer-me um desconto?', 6, 'Pedido de desconto. Comum em mercados e lojas pequenas.'),
('Where is the fitting room?', 'Onde fica o provador?', 6, 'Pergunta em lojas de roupa. Algumas lojas limitam o número de peças que pode levar.'),
('Do you have this in blue?', 'Tem isto em azul?', 6, 'Pergunta sobre cores disponíveis. Substitua "blue" por qualquer outra cor.'),
('I will take it', 'Fico com isto', 6, 'Frase para finalizar uma compra. Pode usar "I\'ll buy this" ou simplesmente "I\'ll take this".');

-- Exemplos para Compras
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(51, '"How much does this cost? Is there a discount for cash?"'),
(52, '"Do you have this in a different size? Medium is too big"'),
(53, '"Can I try it on? How many items can I take to the fitting room?"'),
(54, '"I\'m just looking, thanks. I\'ll call if I need help"'),
(55, '"Do you accept euros or only pounds?" perguntei em Londres.'),
(56, '"That\'s too expensive for my budget. Any similar but cheaper?"'),
(57, '"Can you give me a discount if I buy two?" negociei.'),
(58, '"Where is the fitting room? I have three items to try"'),
(59, '"Do you have this in blue? It\'s my favorite color"'),
(60, '"I will take it. Can you gift-wrap it, please?"');

-- =============================================
-- DIREÇÕES E LOCALIZAÇÕES
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('Excuse me, where is...?', 'Desculpe, onde fica...?', 7, 'Forma educada de começar a pedir direções. Complete com o local que procura.'),
('How far is it?', 'Fica muito longe?', 7, 'Pergunta sobre distância. As respostas podem ser em metros ou minutos a pé.'),
('Can you show me on the map?', 'Pode mostrar-me no mapa?', 7, 'Pedido útil quando explicações verbais são confusas. Tenha um mapa ou app aberta.'),
('Turn left/right', 'Vire à esquerda/direita', 7, 'Instruções básicas de direção. "Left" é esquerda, "right" é direita.'),
('Go straight ahead', 'Siga em frente', 7, 'Instrução para continuar na mesma direção. Pode vir com "for 200 meters".'),
('It''s near/next to...', 'Fica perto/ao lado de...', 7, 'Indicações usando pontos de referência. Útil quando o local não é muito conhecido.'),
('Is it within walking distance?', 'Dá para ir a pé?', 7, 'Pergunta sobre se vale a pena ir caminhando. Geralmente até 15-20 minutos.'),
('I am lost', 'Estou perdido', 7, 'Frase importante quando não sabe onde está. Pode acrescentar "Can you help me?"'),
('Where is the tourist information center?', 'Onde fica o posto de turismo?', 7, 'Pergunta para encontrar ajuda oficial. Eles fornecem mapas e dicas gratuitas.'),
('How do I get back to my hotel?', 'Como volto para o meu hotel?', 7, 'Pergunta para retornar ao alojamento. Tenha o nome e endereço do hotel anotado.');

-- Exemplos para Direções e Localizações
INSERT INTO exemplos (id_expressao, exemplo) VALUES
(61, '"Excuse me, where is the nearest ATM?" perguntei a um transeunte.'),
(62, '"How far is it to the castle from here?"'),
(63, '"Can you show me on the map? I\'m not from around here"'),
(64, '"Turn left at the next traffic light, then right at the café"'),
(65, '"Go straight ahead until you see the yellow building"'),
(66, '"It\'s near the post office, next to the pastry shop"'),
(67, '"Is it within walking distance or should I take a taxi?"'),
(68, '"I am lost. Can you point me to Avenida da Liberdade?"'),
(69, '"Where is the tourist information center? I need a city map"'),
(70, '"How do I get back to my hotel? I\'m staying at the Tivoli"');

-- =============================================
-- TRABALHO E NEGÓCIOS
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('I would like to schedule a meeting', 'Gostaria de marcar uma reunião', 8, 'Frase formal para solicitar um encontro profissional. Pode especificar data/hora depois.'),
('When is the deadline?', 'Quando é o prazo final?', 8, 'Pergunta importante sobre prazos de projetos. Alternativa: "What is the deadline for this?"'),
('Could you send me the report?', 'Pode enviar-me o relatório?', 8, 'Pedido profissional comum. Pode adicionar "by email" para especificar o método.'),
('I need to speak with the manager', 'Preciso de falar com o gerente', 8, 'Frase para solicitar conversa com superior hierárquico.'),
('Let me check my schedule', 'Deixe-me verificar a minha agenda', 8, 'Resposta educada quando precisa de confirmar disponibilidade.'),
('The presentation is ready', 'A apresentação está pronta', 8, 'Informação importante antes de reuniões. Pode adicionar "for the meeting".'),
('Could you clarify this point?', 'Poderia esclarecer este ponto?', 8, 'Frase profissional para pedir explicações adicionais.'),
('I will follow up by email', 'Vou dar seguimento por email', 8, 'Expressão comum para indicar continuação de contacto profissional.'),
('We need to reschedule', 'Precisamos de remarcar', 8, 'Frase útil quando é necessário alterar horários marcados.'),
('Thank you for your time', 'Obrigado pelo seu tempo', 8, 'Expressão de cortesia no final de reuniões ou conversas profissionais.');

INSERT INTO exemplos (id_expressao, exemplo) VALUES
(71, '"I would like to schedule a meeting for next Wednesday" disse ao assistente.'),
(72, '"When is the deadline for the project submission?" perguntei ao colega.'),
(73, '"Could you send me the report by the end of the day?" solicitei.'),
(74, '"I need to speak with the manager about the new contract"'),
(75, '"Let me check my schedule and I\'ll get back to you" respondi.'),
(76, '"The presentation is ready for tomorrow\'s client meeting"'),
(77, '"Could you clarify this point about the budget?" pedi na reunião.'),
(78, '"I will follow up by email with the details" prometi.'),
(79, '"We need to reschedule our appointment due to an emergency"'),
(80, '"Thank you for your time and valuable feedback" disse no final.');

-- =============================================
-- TECNOLOGIA E INTERNET
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('How do I connect to the WiFi?', 'Como me ligo à rede WiFi?', 9, 'Pergunta essencial em hotéis, cafés e espaços públicos. Precisa do nome da rede e senha.'),
('My password is not working', 'A minha palavra-passe não está a funcionar', 9, 'Frase para reportar problemas de acesso. Pode precisar de "reset password".'),
('The website is not loading', 'O site não está a carregar', 9, 'Explicação comum para problemas técnicos. Alternativa: "The page won\'t open".'),
('I forgot my username', 'Esqueci o meu nome de utilizador', 9, 'Problema comum em plataformas online. Geralmente requer recuperação de conta.'),
('Where can I charge my phone?', 'Onde posso carregar o telemóvel?', 9, 'Pergunta prática em locais públicos. Pode especificar o tipo de carregador.'),
('How do I update the app?', 'Como atualizo a aplicação?', 9, 'Dúvida comum sobre manutenção de software. Alternativa: "Check for updates".'),
('The file is too large to send', 'O ficheiro é demasiado grande para enviar', 9, 'Problema técnico comum. Solução pode ser compressão ou serviço de cloud.'),
('Could you help me with this software?', 'Pode ajudar-me com este programa?', 9, 'Pedido de assistência técnica. Especifique o nome do software se possível.'),
('I need to recover my account', 'Preciso de recuperar a minha conta', 9, 'Frase para situações de acesso perdido a contas online.'),
('Is there a computer available?', 'Há algum computador disponível?', 9, 'Pergunta útil em bibliotecas, centros de negócios ou espaços coworking.');

INSERT INTO exemplos (id_expressao, exemplo) VALUES
(81, '"How do I connect to the WiFi? What\'s the password?" perguntei na receção.'),
(82, '"My password is not working even though I\'m sure it\'s correct"'),
(83, '"The website is not loading properly on my mobile device"'),
(84, '"I forgot my username for this platform" disse ao técnico de suporte.'),
(85, '"Where can I charge my phone? My battery is almost dead"'),
(86, '"How do I update the app? It keeps crashing"'),
(87, '"The file is too large to send by email. Any alternatives?"'),
(88, '"Could you help me with this software? I\'m new to it"'),
(89, '"I need to recover my account. I clicked \'forgot password\'"'),
(90, '"Is there a computer available with Photoshop installed?"');

-- =============================================
-- LAZER E ENTRETENIMENTO
-- =============================================
INSERT INTO expressoes (versao_ingles, traducao_portugues, id_categoria, explicacao) VALUES
('What are your hobbies?', 'Quais são os teus hobbies?', 10, 'Pergunta comum em conversas sociais. Respostas típicas incluem atividades como ler, viajar, etc.'),
('Do you want to go out tonight?', 'Queres sair esta noite?', 10, 'Convite informal para atividades sociais. Pode especificar o local depois.'),
('I love this song!', 'Adoro esta música!', 10, 'Expressão de entusiasmo sobre música. Alternativa: "This is my favorite song!".'),
('What time does the concert start?', 'A que horas começa o concerto?', 10, 'Pergunta importante sobre eventos. Verifique também local e preços.'),
('Are there any good museums here?', 'Há bons museus aqui?', 10, 'Pergunta para explorar cultura local. Pode especificar tipo de museu.'),
('Can you recommend a good movie?', 'Podes recomendar um bom filme?', 10, 'Pedido de sugestão para entretenimento. Pode especificar o género.'),
('Let''s take a photo!', 'Vamos tirar uma foto!', 10, 'Sugestão comum em passeios e eventos sociais. Alternativa: "Picture time!".'),
('Where is the best place to dance?', 'Onde é o melhor sítio para dançar?', 10, 'Pergunta sobre vida noturna. Respostas podem incluir clubes ou bares.'),
('I prefer outdoor activities', 'Prefiro atividades ao ar livre', 10, 'Expressão sobre preferências de lazer. Pode especificar como hiking, ciclismo, etc.'),
('That was so much fun!', 'Foi tão divertido!', 10, 'Expressão pós-atividade para mostrar apreço. Alternativa: "I had a great time!".');

INSERT INTO exemplos (id_expressao, exemplo) VALUES
(91, '"What are your hobbies?" perguntou o novo colega durante o almoço.'),
(92, '"Do you want to go out tonight? There\'s a new jazz club opening"'),
(93, '"I love this song! Turn up the volume!" disse no carro.'),
(94, '"What time does the concert start? We don\'t want to be late"'),
(95, '"Are there any good museums here with contemporary art?"'),
(96, '"Can you recommend a good movie for family night?"'),
(97, '"Let\'s take a photo with this amazing view as background!"'),
(98, '"Where is the best place to dance salsa in this city?"'),
(99, '"I prefer outdoor activities like hiking and kayaking"'),
(100, '"That was so much fun! We should do this again soon"');