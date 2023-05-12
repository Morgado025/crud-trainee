escolha = 0
while escolha < 1 or escolha > 10:
    escolha = int(input("Escolha qual exercício deseja executar: "))
    if escolha < 1 or escolha > 10:
        print("Valor Inválido \n")

# Exercício 1
if escolha == 1:
    for i in range(10):
        print(i+1)

# Exercício 2
if escolha == 2:
    for i in range(0,21,2):
        print(i) 

# Exercício 3
if escolha == 3:
    a = []
    for i in range(1,101):
        a.append(i)
    print("A soma dos números será: ",sum(a)) 

# Exercício 4
if escolha == 4:
    a = [1,2,3,4,5,6,7,8,9,10]

    for i in range(len(a)-1, -1, -1):
        print(a[i]) 
    
# Exercício 5
if escolha == 5:
    num = 1
    while num < 20: 
        if num%2 !=0:
            print(num)
        num+=1

# Exercício 6
if escolha == 6:
    arr = [2,5,8,11,14]
    for i, n in enumerate(arr):
        if n % 2 == 1:
            print(f'O número {n} é ímpar e está no índice {i}')
            cond = False 
        
# Exercício 7
if escolha == 7:
    for i in range(1, 101):
        if i % 3 == 0:
            print(i)
            cond = False 

# Exercício 8    
if escolha == 8:
    cadastro = []
    n_cad = int(input('Quantos nomes você quer cadastrar? (mínimo 10): '))
    if n_cad >= 10:
        for i in range(1,n_cad+1):
            cadastro.append(input(f"Nome do usuário {i}: "))
        print('')
        print('Aqui está a lista de todos os usuário')
        for i, name in enumerate(cadastro):
            print(f'{i}. {name}.')
    else:
        print('Digite o número maior ou igual que 10')
    cond = False

# Exercício 9
if escolha == 9:
    qnt_prod = int(input('Quantos produtos você quer cadastrar? (mínimo 10) '))
    prod = []
    if qnt_prod >= 10:
        for i in range(1, qnt_prod+1):
            prod.append(input(f'Digite o nome do produto {i}: '))
        print('Aqui está a lista de produtos: ')
        cond = True
        while cond: 
            for i, n in enumerate(prod):
                print(f'{i} - {n}')
            
            try: 
                x = input('Digite o nome do produto que você gostaria de comprar: ')
                prod.remove(x)
                if len(prod) == 0:
                    print('A lista de produtos ficou vazia, não há mais itens para serem comprados')
                    cond = False
                
            except:
                print('Digite o nome do produto correto')
        
# Exercício 10
if escolha == 10:
    listOne = []
    price = []
    score = []
    x = int(input('Quantos jogos você deseja cadastrar? '))
    for i in range(x):
        listOne.append(input(f'\nNome do jogo {i+1}: '))
        price.append(float(input(f'Preço do jogo {listOne[i]}: ')))

        t = True
        while t: 
            scr = int(input(f'Nota do jogo {listOne[i]}: '))
            if 0 < scr <= 10:
                score.append(scr)
                t = False
            else: 
                print('Digite a nota do jogo de 1 a 10')

                
    print('\nTodos os jogos com seus preços e devidas notas')
    for i, n in enumerate(listOne):
        print(f'Nome: {n}, Preço: {price[i]}, Nota: {score[i]}')

    best, worst = score[0], score[0]
    indexB, indexW, indexOne, indexTwo = 0,0,0,0
    for i, n in enumerate(score):
        if n > best:
            best = n
            indexB = i
        if n < worst: 
            worst = n
            indexW = i
    
    priceOne, priceTwo = price[0], price[0]
    for i, n in enumerate(price):
        if n > priceOne:
            priceOne = n
            indexOne = i
        if n < priceTwo:
            priceTwo = n
            indexTwo = i 
            

    print(f'\nJogo melhor avaliado {listOne[indexB]}')
    print(f'Jogo pior avaliado {listOne[indexW]}')
    print(f'Jogo mais caro {listOne[indexOne]}')
    print(f'Jogo mais barato {listOne[indexTwo]}')
