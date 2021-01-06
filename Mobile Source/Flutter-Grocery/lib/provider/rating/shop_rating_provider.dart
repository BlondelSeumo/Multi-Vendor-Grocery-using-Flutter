import 'dart:async';
import 'package:fluttermultigrocery/repository/shop_rating_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/viewobject/shop_rating.dart';

class ShopRatingProvider extends PsProvider {
  ShopRatingProvider({@required ShopRatingRepository repo, int limit = 0})
      : super(repo, limit) {
    _repo = repo;
    print('Shop Rating Provider: $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });

    shopRatingListStream =
        StreamController<PsResource<List<ShopRating>>>.broadcast();
    subscription = shopRatingListStream.stream
        .listen((PsResource<List<ShopRating>> resource) {
      updateOffset(resource.data.length);

      _shopRatingList = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }

  ShopRatingRepository _repo;

  PsResource<ShopRating> _shopRating =
      PsResource<ShopRating>(PsStatus.NOACTION, '', null);
  PsResource<ShopRating> get shopRating => _shopRating;

  PsResource<List<ShopRating>> _shopRatingList =
      PsResource<List<ShopRating>>(PsStatus.NOACTION, '', <ShopRating>[]);

  PsResource<List<ShopRating>> get ratingList => _shopRatingList;
  StreamSubscription<PsResource<List<ShopRating>>> subscription;
  StreamController<PsResource<List<ShopRating>>> shopRatingListStream;

  @override
  void dispose() {
    subscription.cancel();
    isDispose = true;
    print('Rating Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> postShopRating(
    Map<dynamic, dynamic> jsonMap,
  ) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();

    _shopRating = await _repo.postShopRating(
        shopRatingListStream, jsonMap, isConnectedToInternet);

    return _shopRating;
  }

  Future<dynamic> loadShopRatingList(String shopId) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getAllShopRatingList(shopRatingListStream, shopId,
        isConnectedToInternet, limit, offset, PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> refreshShopRatingList(String shopId) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getAllShopRatingList(shopRatingListStream, shopId,
        isConnectedToInternet, limit, 0, PsStatus.PROGRESS_LOADING,
        isNeedDelete: false);
  }
}
