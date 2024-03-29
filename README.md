# トランプゲームの戦争

戦争は、プレイヤーがカードを出し合って、カードの数の大小を比べて、強いカードを出したほうが勝ちとなり、カードをもらいます。このようにして続けていき、誰かの手札がなくなったら終了します。最後に多くカードを持っていた人が勝ちになります。ルールは次の通りです。

- 53枚のカードを使います。うち1枚はジョーカーです。
- プレイヤーの人数は2〜5人です。
- 開始時、親になった人は、カードをよく切り、各プレイヤーに裏向きで均等に配ります。配られたカードを手札といいます。手札は裏向きのままにしておきます。
- 「戦争！」の掛け声とともに、各プレイヤーは裏向きの手札束の一番上のカードを、場にオモテ向きに置きます。
- 出したカードの強さの大小を比べて、一番強いカードを出した人が勝ちとなり、場札（手札からめくられ場にオモテ向きに出されたカード）をもらいます。カードは強い方から、ジョーカー、A、K、Q、J、10、9、8、7、6、5、4、3、2 の順番になります。勝者がとった場札は手元に置いておき、手札が0枚になった際によく切って手札に加えます。
- 一番強い数値が複数出た場合、もう一度手札からカードを出します。そして、勝ったプレイヤーが場札をもらいます。同じ数字が続いたら、勝ち負けが決まるまでカードを出します。ただし、出された一番強いカードがAで複数あった場合、「スペードの A」は「世界一」と呼ばれ、無条件で場札をとることができます。
- 誰かの手札がなくなったらゲーム終了です。この時点での手札の枚数が多い順に1位、2位、・・・という順位になります。

コンソール画面のイメージは次の通りです。

```bash
戦争を開始します。
プレイヤーの人数を入力してください（2〜5）: 3
プレイヤー1の名前を入力してください: たろう
プレイヤー2の名前を入力してください: じろう
プレイヤー3の名前を入力してください: さぶろう
カードが配られました。
戦争！

たろうのカードはハートの7です。
じろうのカードはクラブの7です。
さぶろうのカードはクラブの4です。
引き分けです。
#一番強い数値が複数出た場合、もう一度手札からカードを出します。
戦争！
たろうのカードはダイヤのQです。
じろうのカードはスペードの7です。
さぶろうのカードはスペードの3です。
たろうが勝ちました。たろうはカードを3枚もらいました。
#出したカードの強さの大小を比べて、一番強いカードを出した人が勝ちとなり、場札（手札からめくられ場にオモテ向きに出されたカード）をもらいます。
戦争！
たろうのカードはジョーカーです。
じろうのカードはスペードの7です。
さぶろうのカードはスペードの3です。
たろうが勝ちました。たろうはカードを3枚もらいました。
#ジョーカーは最強のカードです。
戦争！
たろうのカードはダイヤのQです。
じろうのカードはスペードのAです。
さぶろうのカードはダイヤのAです。
じろうが勝ちました。じろうはカードを3枚もらいました。
#出された一番強いカードがAで複数あった場合、「スペードの A」は「世界一」と呼ばれ、無条件で場札をとることができます。
...（省略）
じろうの手札がなくなりました。
たろうの手札の枚数は27枚です。じろうの手札の枚数は0枚です。さぶろうの手札の枚数は24枚です。
たろうが1位、さぶろうが2位、じろうが3位です。
#誰かの手札がなくなったらゲーム終了です。この時点での手札の枚数が多い順に1位、2位、・・・という順位になります。
戦争を終了します。
```
