// Fill out your copyright notice in the Description page of Project Settings.

#include "MyProject.h"
#include "TestSingleton.h"


UTestSingleton::UTestSingleton(const class FPostConstructInitializeProperties& PCIP)
	: Super(PCIP)
{
	static ConstructorHelpers::FObjectFinder<UDataTable> ItemTable_BP(TEXT("DataTable'/Game/ItemDatabase.ItemDatabase'"));
	ItemTable= ItemTable_BP.Object;
}

UTestSingleton& UTestSingleton::Get()
{
	UTestSingleton *Singleton= Cast<UTestSingleton>(GEngine->GameSingleton);

	if(Singleton)
	{
		return *Singleton;
	}
	else
	{
		return *ConstructObject<UTestSingleton>(UTestSingleton::StaticClass());
	}
}

bool UTestSingleton::Tick(float DeltaSeconds)
{
	return true;
}


