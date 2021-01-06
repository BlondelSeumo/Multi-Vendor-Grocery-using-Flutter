import 'dart:async';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/repository/shop_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/api_status.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:fluttermultigrocery/viewobject/holder/shop_parameter_holder.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';

class ShopProvider extends PsProvider {
  ShopProvider({ShopRepository repo, this.psValueHolder, int limit = 0})
      : super(repo, limit) {
    _repo = repo;
    print('ShopProvider : $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });

    shopListStream = StreamController<PsResource<List<Shop>>>.broadcast();
    subscription =
        shopListStream.stream.listen((PsResource<List<Shop>> resource) {
      _shop = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }

  ShopRepository _repo;
  PsValueHolder psValueHolder;
  Shop selectedShop;

  PsResource<List<Shop>> _shop =
      PsResource<List<Shop>>(PsStatus.NOACTION, '', null);

  PsResource<List<Shop>> get shop => _shop;
  StreamSubscription<PsResource<List<Shop>>> subscription;
  StreamController<PsResource<List<Shop>>> shopListStream;

  PsResource<ApiStatus> _apiStatus =
      PsResource<ApiStatus>(PsStatus.NOACTION, '', null);
  PsResource<ApiStatus> get user => _apiStatus;

  @override
  void dispose() {
    subscription.cancel();
    isDispose = true;
    print('Shop Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> loadShopListByKey(
      ShopParameterHolder shopParameterHolder) async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    isLoading = true;
    await _repo.getShopList(shopListStream, isConnectedToInternet, limit,
        offset, PsStatus.PROGRESS_LOADING, shopParameterHolder);
  }

  Future<dynamic> nextShopListByKey(
      ShopParameterHolder shopParameterHolder) async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;

      await _repo.getNextPageShopList(shopListStream, isConnectedToInternet,
          limit, offset, PsStatus.PROGRESS_LOADING, shopParameterHolder);
    }
  }

  Future<void> resetShopList(ShopParameterHolder shopParameterHolder) async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    updateOffset(0);

    isLoading = true;
    await _repo.getShopList(shopListStream, isConnectedToInternet, limit,
        offset, PsStatus.PROGRESS_LOADING, shopParameterHolder);
  }

  Future<dynamic> postTouchCount(
    Map<dynamic, dynamic> jsonMap,
  ) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();

    _apiStatus = await _repo.postTouchCount(
        jsonMap, isConnectedToInternet, PsStatus.PROGRESS_LOADING);

    return _apiStatus;
  }
}
