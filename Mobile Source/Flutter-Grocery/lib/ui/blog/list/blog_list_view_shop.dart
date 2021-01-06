import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/constant/ps_dimens.dart';
import 'package:fluttermultigrocery/constant/route_paths.dart';
import 'package:fluttermultigrocery/provider/blog/blog_provider.dart';
import 'package:fluttermultigrocery/repository/blog_repository.dart';
import 'package:fluttermultigrocery/ui/blog/item/blog_list_item.dart';
import 'package:fluttermultigrocery/ui/common/ps_ui_widget.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:provider/provider.dart';

class BlogListViewShop extends StatefulWidget {
  const BlogListViewShop(
      {Key key, @required this.animationController, @required this.shopId})
      : super(key: key);
  final AnimationController animationController;
  final String shopId;
  @override
  BlogListViewShopState createState() => BlogListViewShopState();
}

class BlogListViewShopState extends State<BlogListViewShop>
    with TickerProviderStateMixin {
  final ScrollController _scrollController = ScrollController();

  BlogProvider _blogProvider;
  Animation<double> animation;

  @override
  void dispose() {
    animation = null;
    super.dispose();
  }

  @override
  void initState() {
    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        _blogProvider.nextBlogListWithShopId(widget.shopId);
      }
    });

    super.initState();
  }

  BlogRepository repo1;
  PsValueHolder valueHolder;
  dynamic data;
  bool isConnectedToInternet = false;
  bool isSuccessfullyLoaded = true;

  void checkConnection() {
    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
      if (isConnectedToInternet && PsConst.SHOW_ADMOB) {
        setState(() {});
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    if (!isConnectedToInternet && PsConst.SHOW_ADMOB) {
      print('loading ads....');
      checkConnection();
    }
    repo1 = Provider.of<BlogRepository>(context);
    valueHolder = Provider.of<PsValueHolder>(context);

    print(
        '............................Build UI Again ............................');
    return ChangeNotifierProvider<BlogProvider>(
      lazy: false,
      create: (BuildContext context) {
        final BlogProvider provider = BlogProvider(repo: repo1);
        provider.loadBlogListWithShopId(widget.shopId);
        _blogProvider = provider;
        return _blogProvider;
      },
      child: Consumer<BlogProvider>(
        builder: (BuildContext context, BlogProvider provider, Widget child) {
          if (provider.blogList != null &&
              provider.blogList.data != null &&
              provider.blogList.data.isNotEmpty) {
            return Stack(
              children: <Widget>[
                Container(
                    margin: const EdgeInsets.only(
                        left: PsDimens.space16,
                        right: PsDimens.space16,
                        top: PsDimens.space8,
                        bottom: PsDimens.space8),
                    child: RefreshIndicator(
                      child: CustomScrollView(
                          controller: _scrollController,
                          scrollDirection: Axis.vertical,
                          shrinkWrap: true,
                          slivers: <Widget>[
                            SliverList(
                              delegate: SliverChildBuilderDelegate(
                                (BuildContext context, int index) {
                                  final int count =
                                      provider.blogList.data.length;
                                  return BlogListItem(
                                    animationController:
                                        widget.animationController,
                                    animation:
                                        Tween<double>(begin: 0.0, end: 1.0)
                                            .animate(
                                      CurvedAnimation(
                                        parent: widget.animationController,
                                        curve: Interval(
                                            (1 / count) * index, 1.0,
                                            curve: Curves.fastOutSlowIn),
                                      ),
                                    ),
                                    blog: provider.blogList.data[index],
                                    onTap: () {
                                      print(provider.blogList.data[index]
                                          .defaultPhoto.imgPath);
                                      Navigator.pushNamed(
                                          context, RoutePaths.blogDetail,
                                          arguments:
                                              provider.blogList.data[index]);
                                    },
                                  );
                                },
                                childCount: provider.blogList.data.length,
                              ),
                            ),
                          ]),
                      onRefresh: () {
                        return provider.resetBlogListWithShopId(widget.shopId);
                      },
                    )),
                PSProgressIndicator(provider.blogList.status)
              ],
            );
          } else {
            return Container();
          }
        },
      ),
    );
  }
}
