import 'package:flutter/material.dart';

class PsHero extends StatelessWidget {
  const PsHero({
    @required this.tag,
    this.createRectTween,
    this.flightShuttleBuilder,
    this.placeholderBuilder,
    this.transitionOnUserGestures = false,
    @required this.child,
  })  : assert(tag != null),
        assert(transitionOnUserGestures != null),
        assert(child != null),
        super();

  final Object tag;
  final CreateRectTween createRectTween;
  final HeroFlightShuttleBuilder flightShuttleBuilder;
  final HeroPlaceholderBuilder placeholderBuilder;
  final bool transitionOnUserGestures;
  final Widget child;

  @override
  Widget build(BuildContext context) {
    if (tag != null && tag != '') {
      return Hero(
        tag: tag,
        key: key,
        createRectTween: createRectTween,
        flightShuttleBuilder: flightShuttleBuilder,
        placeholderBuilder: placeholderBuilder,
        transitionOnUserGestures: transitionOnUserGestures,
        child: child,
      );
    } else {
      return child;
    }
  }
}
