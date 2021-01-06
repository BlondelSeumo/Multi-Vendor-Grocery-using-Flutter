import 'dart:async';
import 'package:fluttermultigrocery/repository/shipping_area_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/api_status.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/viewobject/shipping_area.dart';

class ShippingAreaProvider extends PsProvider {
  ShippingAreaProvider(
      {@required ShippingAreaRepository repo,
      @required this.psValueHolder,
      int limit = 0})
      : super(repo, limit) {
    _repo = repo;

    //isDispose = false;
    print('ShippingArea Provider: $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });

    shippingAreaListStream =
        StreamController<PsResource<List<ShippingArea>>>.broadcast();
    subscription = shippingAreaListStream.stream
        .listen((PsResource<List<ShippingArea>> resource) {
      updateOffset(resource.data.length);

      _shippingAreaList = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }
  StreamController<PsResource<List<ShippingArea>>> shippingAreaListStream;
  ShippingAreaRepository _repo;
  PsValueHolder psValueHolder;

  PsResource<List<ShippingArea>> _shippingAreaList =
      PsResource<List<ShippingArea>>(PsStatus.NOACTION, '', <ShippingArea>[]);

  PsResource<List<ShippingArea>> get shippingAreaList => _shippingAreaList;
  StreamSubscription<PsResource<List<ShippingArea>>> subscription;

  final PsResource<ApiStatus> _apiStatus =
      PsResource<ApiStatus>(PsStatus.NOACTION, '', null);
  PsResource<ApiStatus> get user => _apiStatus;
  @override
  void dispose() {
    //_repo.cate.close();
    subscription.cancel();
    isDispose = true;
    print('ShippingArea Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> getShippingAreaById(String shippingId) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();

    return await _repo.getShippingById(
        isConnectedToInternet, shippingId, PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> loadShippingAreaList(String shopId) async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();

    await _repo.getAllShippingAreaList(
        shippingAreaListStream,
        isConnectedToInternet,
        shopId,
        limit,
        offset,
        PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> nextShippingAreaList(String shopId) async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;
      await _repo.getNextPageShippingAreaList(
          shippingAreaListStream,
          isConnectedToInternet,
          shopId,
          limit,
          offset,
          PsStatus.PROGRESS_LOADING);
    }
  }

  Future<void> resetShippingAreaList(String shopId) async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    isLoading = true;

    updateOffset(0);

    await _repo.getAllShippingAreaList(
        shippingAreaListStream,
        isConnectedToInternet,
        shopId,
        limit,
        offset,
        PsStatus.PROGRESS_LOADING);

    isLoading = false;
  }
}
